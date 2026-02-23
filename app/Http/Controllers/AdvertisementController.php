<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\MasterCity;
use App\Models\Partner;
use App\Enums\GoalType;
use App\Enums\StickerAreaType;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Facades\ActivityLog;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    use HasPermissions;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check permission to view advertisements
        $viewPermissionLevel = $this->getViewPermissionLevel('my-ads');
        if (!$viewPermissionLevel) {
            return redirect()->route('my-dashboard')->with('error', 'You do not have permission to view advertisements.');
        }

        $status = $request->get('status', '');
        
        // Apply permission-based filtering
        if ($viewPermissionLevel === 'own') {
            $query = Advertisement::with('transactions')->where('customer_id', $user->id);
        } else {
            $query = Advertisement::with('transactions');
        }

        // Filter by status if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $ads = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get available statuses for filter dropdown
        $statuses = Advertisement::distinct()
            ->where('customer_id', $user->id)
            ->pluck('status')
            ->sort()
            ->values()
            ->toArray();

        return view('customer.advertisement.index', compact('ads', 'statuses', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check create permission
        $authResponse = $this->authorizeAction('my-ads.create', 'You do not have permission to create advertisements.');
        if ($authResponse) {
            return redirect()->route('my-dashboard')->withErrors(['permission' => $authResponse->getData()->message]);
        }

        $goalTypes = GoalType::options();
        $stickerAreas = StickerAreaType::options();
        $cities = MasterCity::orderBy('name')->get();

        return view('customer.advertisement.create', compact('goalTypes', 'stickerAreas', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check create permission
        $authResponse = $this->authorizeAction('my-ads.create', 'You do not have permission to create advertisements.');
        if ($authResponse) {
            return redirect()->back()->withErrors(['permission' => $authResponse->getData()->message]);
        }

        try{
            $minStartdate = Carbon::now()->addWeeks(2)->format('Y-m-d');
            $minEnddate = $request->startdate 
            ? Carbon::parse($request->startdate)->addDays(30)->format('Y-m-d')
            : null;
            //dd($request);
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'goal_type' => 'required|string|in:' . implode(',', GoalType::values()),
                'target_location_id' => 'required|exists:master_cities,id',
                'sticker_area_type' => 'required|string|in:' . implode(',', StickerAreaType::values()),
                'target_distance' => 'required|numeric|min:100',
                'target_partner' => 'nullable|numeric|min:1',
                'startdate' => 'required|date|after_or_equal:' . $minStartdate,
                'enddate' => 'nullable|date|after_or_equal:' . $minEnddate,
                'total_budget' => 'nullable|numeric|min:0',
                'description' => 'nullable|string|max:1000',
            ]);

            $user = Auth::user();
            
            // Calculate duration if enddate is provided
            $duration = null;
            if ($request->filled('enddate')) {
                $start = Carbon::parse($validated['startdate']);
                $end = Carbon::parse($validated['enddate']);
                $duration = $start->diffInDays($end);
            }

            $advertisement = Advertisement::create([
                'customer_id' => $user->id,
                'title' => $validated['title'],
                'goal_type' => $validated['goal_type'],
                'sticker_area_type' => $validated['sticker_area_type'],
                'target_location_id' => $validated['target_location_id'],
                'target_distance' => $validated['target_distance'],
                'target_partner' => $validated['target_partner'] ?? null,
                'startdate' => $validated['startdate'],
                'enddate' => $validated['enddate'] ?? null,
                'duration' => $duration,
                'total_budget' => Advertisement::calculatePrice($validated['sticker_area_type'],$validated['target_partner'],$validated['target_distance']),
                'description' => $validated['description'] ?? null,
                'status' => 'draft',
                'draft_at' => Carbon::now(),
            ]);
            ActivityLog::log($user->id, 'Membuat iklan baru dengan ID: ' . $advertisement->id, 'advertisement_create', $advertisement->toArray());
            return redirect()->route('my-ads.index')->with('success', 'Iklan berhasil dibuat!');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat iklan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        $user = Auth::user();

        // Check if user has permission to view this advertisement
        if (!$this->canPerform('view_own', 'my-ads', $advertisement->customer_id) && $user->id !== $advertisement->customer_id) {
            return redirect()->route('my-dashboard')->with('error', 'You do not have permission to view this advertisement.');
        }

        return view('customer.advertisement.detail', compact('advertisement'));
    }



    /**
     * Calculate advertisement price based on sticker type, vehicle count, and distance
     */
    public function calculatePrice(Request $request)
    {
        $validated = $request->validate([
            'sticker_type' => 'required|string|in:' . implode(',', StickerAreaType::values()),
            'vehicle_count' => 'required|integer|min:1',
            'distance' => 'required|numeric|min:0',
            'budget' => 'nullable|integer|min:0',
        ]);

        // Get sticker area type enum to get the price
        $stickerType = StickerAreaType::tryFrom($validated['sticker_type']);
        if (!$stickerType) {
            return response()->json([
                'success' => false,
                'message' => 'Tipe stiker tidak valid'
            ], 422);
        }

        $vehicleCount = $validated['vehicle_count'];
        $distance = $validated['distance'];
        $budget = $validated['budget'] ?? 0;

        $totalPrice = Advertisement::calculatePrice($stickerType->value, $vehicleCount, $distance);
        
        $finalVehicleCount = $vehicleCount;
        $finalDistance = $distance;
        $budgetAdjusted = false;
        $adjustmentMessage = '';

        // If budget is set and exceeds, optimize the combination
        if ($budget > 0 && $totalPrice > $budget) {
            $budgetAdjusted = true;
            
            // Find the best combination closest to budget
            $bestCombination = [
                'vehicles' => $vehicleCount,
                'distance' => $distance,
                'price' => $totalPrice,
                'diff' => abs($totalPrice - $budget)
            ];

            // Try reducing vehicle count
            for ($v = $vehicleCount; $v >= 1; $v--) {
                $price = Advertisement::calculatePrice($stickerType->value, $v, $distance);
                $diff = abs($price - $budget);
                if ($diff < $bestCombination['diff']) {
                    $bestCombination = [
                        'vehicles' => $v,
                        'distance' => $distance,
                        'price' => $price,
                        'diff' => $diff
                    ];
                }
            }

            // Try reducing distance
            for ($d = $distance; $d >= 1; $d -= 10) {
                $price = Advertisement::calculatePrice($stickerType->value, $vehicleCount, $d);
                $diff = abs($price - $budget);
                if ($diff < $bestCombination['diff']) {
                    $bestCombination = [
                        'vehicles' => $vehicleCount,
                        'distance' => $d,
                        'price' => $price,
                        'diff' => $diff
                    ];
                }
            }

            // Try reducing both proportionally
            if ($vehicleCount > 0 && $distance > 0) {
                $ratio = $budget / $totalPrice;
                if ($ratio < 1) {
                    $reducedDistance = floor($distance * $ratio);
                    if ($reducedDistance >= 1) {
                        $price = Advertisement::calculatePrice($stickerType->value, $vehicleCount, $reducedDistance);
                        $diff = abs($price - $budget);
                        if ($diff < $bestCombination['diff']) {
                            $bestCombination = [
                                'vehicles' => $vehicleCount,
                                'distance' => $reducedDistance,
                                'price' => $price,
                                'diff' => $diff
                            ];
                        }
                    }
                }
            }

            $finalVehicleCount = $bestCombination['vehicles'];
            $finalDistance = $bestCombination['distance'];
            $totalPrice = $bestCombination['price'];
            $adjustmentMessage = "Kendaraan: {$vehicleCount} → {$finalVehicleCount}, Jarak: {$distance} → {$finalDistance} KM";
        }

        return response()->json([
            'success' => true,
            'data' => [
                'price' => (int) round($totalPrice),
                'formatted_price' => 'Rp ' . number_format(round($totalPrice), 0, ',', '.'),
                'vehicles' => $finalVehicleCount,
                'distance' => $finalDistance,
                'breakdown' => "{$finalVehicleCount} kendaraan × {$finalDistance} km",
                'budget_adjusted' => $budgetAdjusted,
                'adjustment_message' => $adjustmentMessage,
            ]
        ]);
    }

    /**
     * Cancel the specified advertisement order.
     */
    public function cancelOrder(Request $request, Advertisement $advertisement)
    {
        $user = Auth::user();

        // Check if user has permission to cancel this advertisement
        if (!$this->canPerform('edit_own', 'my-ads', $advertisement->customer_id) && $user->id !== $advertisement->customer_id) {
            return redirect()->route('my-ads.index')->with('error', 'You do not have permission to cancel this advertisement.');
        }

        // Only allow canceling if status is 'draft' or 'on_review'
        if(!$advertisement->allow_cancel) {
            return redirect()->route('my-ads.index')->with('error', 'Iklan tidak dapat dibatalkan pada status saat ini.');
        }
        try{
            $advertisement->status = 'cancel';
            $advertisement->cancel_at = Carbon::now();
            $advertisement->save();
            ActivityLog::log(Auth::id(), 'Membatalkan iklan dengan ID: ' . $advertisement->id, 'advertisement_cancel', $advertisement->toArray());
            return redirect()->route('my-ads.index')->with('success', 'Iklan berhasil dibatalkan.');
        }catch (\Exception $e) {
            Log::error('Error canceling advertisement ID ' . $advertisement->id . ': ' . $e->getMessage());
            return redirect()->route('my-ads.index')->with('error', 'Terjadi kesalahan saat membatalkan iklan: ' . $e->getMessage());
        }
    }
}

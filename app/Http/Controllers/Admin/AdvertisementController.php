<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Customer;
use App\Models\MasterCity;
use App\Enums\GoalType;
use App\Enums\StickerAreaType;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        // Check permission
        if (!$user->role->canPerform('view', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = Advertisement::with('customer', 'location');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $advertisements = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = Advertisement::distinct()->pluck('status')->sort()->values()->toArray();

        return view('admin.advertisements.index', compact('advertisements', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customers = Customer::all();
        return view('admin.advertisements.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'budget' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        Advertisement::create($validated);

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement created successfully');
    }

    public function show(Advertisement $advertisement)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.advertisements.show', compact('advertisement'));
    }

    public function edit(Advertisement $advertisement)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $goalTypes = GoalType::cases();
        $stickerTypes = StickerAreaType::cases();
        $cities = MasterCity::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();

        return view('admin.advertisements.edit', compact(
            'advertisement',
            'goalTypes',
            'stickerTypes',
            'cities',
            'customers'
        ));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $advertisement->update($validated);

        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement updated successfully');
    }

    public function destroy(Advertisement $advertisement)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'advertisements')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Advertisement deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Enums\PartnerStatus;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = Partner::with('district','city','province');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $partners = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = PartnerStatus::options();

        return view('admin.partners.index', compact('partners', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'village' => 'nullable|string',
            'no_ktp' => 'nullable|string',
            'img_ktp' => 'nullable',
            'img_sim' => 'nullable',
        ]);

        if ($request->hasFile('img_ktp')) {
            $path = $request->file('img_ktp')->store('partners/ktp', 'public');
            $validated['img_ktp'] = $path;
        }

        if ($request->hasFile('img_sim')) {
            $path = $request->file('img_sim')->store('partners/sim', 'public');
            $validated['img_sim'] = $path;
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully');
    }

    public function show(Partner $partner)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }
        
//dd(\DB::getSchemaBuilder()->getColumnListing('partners'));

        return view('admin.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $statuses = PartnerStatus::options();

        return view('admin.partners.edit', compact('partner', 'statuses'));
    }

    public function update(Request $request, Partner $partner)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'village' => 'nullable|string',
            'no_ktp' => 'nullable|string',
            'img_ktp' => 'nullable',
            'img_sim' => 'nullable',
        ]); 
        if ($request->hasFile('img_ktp')) {
            if ($partner->img_ktp) {
                Storage::disk('public')->delete($partner->img_ktp);
            }
            $data['img_ktp'] = $request->file('img_ktp')->store('partners/ktp', 'public');
        }

        if ($request->hasFile('img_sim')) {
            if ($partner->img_sim) {
                Storage::disk('public')->delete($partner->img_sim);
            }
            $data['img_sim'] = $request->file('img_sim')->store('partners/sim', 'public');
        }
        $partner->update($validated);

        return redirect()->route('admin.partners.show', $partner)
            ->with('success', 'Partner updated successfully');
    }

    public function destroy(Partner $partner)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully');
    }
}

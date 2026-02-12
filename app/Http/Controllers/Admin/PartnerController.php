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
        $query = Partner::query();

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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully');
    }

    public function show(Partner $partner)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'partners')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

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
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerReport;
use App\Models\Partner;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = PartnerReport::with('partner');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = PartnerReport::distinct()->pluck('status')->sort()->values()->toArray();

        return view('admin.reports.index', compact('reports', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $partners = Partner::all();
        return view('admin.reports.create', compact('partners'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        PartnerReport::create($validated);

        return redirect()->route('admin.reports.index')->with('success', 'Report created successfully');
    }

    public function show(PartnerReport $report)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.reports.show', compact('report'));
    }

    public function edit(PartnerReport $report)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $partners = Partner::all();
        return view('admin.reports.edit', compact('report', 'partners'));
    }

    public function update(Request $request, PartnerReport $report)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $report->update($validated);

        return redirect()->route('admin.reports.show', $report)->with('success', 'Report updated successfully');
    }

    public function destroy(PartnerReport $report)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'reports')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully');
    }
}

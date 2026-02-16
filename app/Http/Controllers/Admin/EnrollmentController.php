<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Customer;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = Enrollment::with('partner','advertisement');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = Enrollment::distinct()->pluck('status')->sort()->values()->toArray();

        return view('admin.enrollments.index', compact('enrollments', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customers = Customer::all();
        return view('admin.enrollments.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'advertisement_id' => 'nullable|exists:advertisements,id',
            'status' => 'required|string',
            'remarks' => 'nullable',
            'rate' => 'nullable',
            'achievement' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        Enrollment::create($validated);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment created successfully');
    }

    public function show(Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customers = Customer::all();
        return view('admin.enrollments.edit', compact('enrollment', 'customers'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'advertisement_id' => 'nullable|exists:advertisements,id',
            'status' => 'required|string',
            'remarks' => 'nullable',
            'rate' => 'nullable',
            'achievement' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        $enrollment->update($validated);

        return redirect()->route('admin.enrollments.show', $enrollment)->with('success', 'Enrollment updated successfully');
    }

    public function destroy(Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'enrollments')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment deleted successfully');
    }
}

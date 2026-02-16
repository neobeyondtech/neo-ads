<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerType;
use App\Models\User;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerTypeController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customer_type = CustomerType::orderBy('name')->paginate(15);

        return view('admin.customer_types.index', compact('customer_type'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }
 
        return view('admin.customer_types.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CustomerType::create($validated);

        return redirect()->route('admin.customer_types.index')->with('success', 'Customer created successfully');
    }

    public function show(CustomerType $customer_type)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.customer_types.show', compact('customer_type'));
    }

    public function edit(CustomerType $customer_type)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.customer_types.edit', compact('customer_type'));
    }

    public function update(Request $request, CustomerType $customer_type)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer_type->update($validated);

        return redirect()->route('admin.customer_types.show', $customer_type)
            ->with('success', 'Customer updated successfully');
    }

    public function destroy(CustomerType $customer_type)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'customer_types')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customer_type->delete();

        return redirect()->route('admin.customer_types.index')
            ->with('success', 'Customer deleted successfully');
    }
}

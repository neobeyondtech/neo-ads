<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCategory;
use App\Models\User;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCategoriesController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customer_categorie = CustomerCategory::orderBy('name')->paginate(15);

        return view('admin.customer_categories.index', compact('customer_categorie'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }
 
        return view('admin.customer_categories.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CustomerCategory::create($validated);

        return redirect()->route('admin.customer_categories.index')->with('success', 'Customer created successfully');
    }

    public function show(CustomerCategory $customer_categorie)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.customer_categories.show', compact('customer_categorie'));
    }

    public function edit(CustomerCategory $customer_categorie)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.customer_categories.edit', compact('customer_categorie'));
    }

    public function update(Request $request, CustomerCategory $customer_categorie)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer_categorie->update($validated);

        return redirect()->route('admin.customer_categories.show', $customer_categorie)
            ->with('success', 'Customer updated successfully');
    }

    public function destroy(CustomerCategory $customer_categorie)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'customer_categories')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customer_categorie->delete();

        return redirect()->route('admin.customer_categories.index')
            ->with('success', 'Customer deleted successfully');
    }
}

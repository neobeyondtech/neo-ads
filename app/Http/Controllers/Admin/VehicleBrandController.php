<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleBrandController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $brands = VehicleBrand::orderBy('name')->paginate(15);

        return view('admin.vehicle-brands.index', compact('brands'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.vehicle-brands.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_brands',
        ]);

        VehicleBrand::create($validated);

        return redirect()->route('admin.vehicle-brands.index')
            ->with('success', 'Vehicle Brand created successfully');
    }

    public function edit(VehicleBrand $brand)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.vehicle-brands.edit', compact('brand'));
    }

    public function update(Request $request, VehicleBrand $brand)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_brands,name,' . $brand->id,
        ]);

        $brand->update($validated);

        return redirect()->route('admin.vehicle-brands.index')
            ->with('success', 'Vehicle Brand updated successfully');
    }

    public function destroy(VehicleBrand $brand)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $brand->delete();

        return redirect()->route('admin.vehicle-brands.index')
            ->with('success', 'Vehicle Brand deleted successfully');
    }
}

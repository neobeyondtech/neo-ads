<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvinceController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $provinces = MasterProvince::orderBy('name')->paginate(15);

        return view('admin.provinces.index', compact('provinces'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.provinces.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_provinces',
        ]);

        MasterProvince::create($validated);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province created successfully');
    }

    public function edit(MasterProvince $province)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, MasterProvince $province)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_provinces,name,' . $province->id,
        ]);

        $province->update($validated);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province updated successfully');
    }

    public function destroy(MasterProvince $province)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $province->delete();

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province deleted successfully');
    }
}

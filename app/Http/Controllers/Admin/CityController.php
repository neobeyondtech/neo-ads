<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterProvince;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $cities = MasterCity::with('province')->orderBy('name')->paginate(15);

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $provinces = MasterProvince::orderBy('name')->get();

        return view('admin.cities.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:master_provinces,id',
        ]);

        MasterCity::create($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City created successfully');
    }

    public function edit(MasterCity $city)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $provinces = MasterProvince::orderBy('name')->get();

        return view('admin.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, MasterCity $city)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:master_provinces,id',
        ]);

        $city->update($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City updated successfully');
    }

    public function destroy(MasterCity $city)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDistrict;
use App\Models\MasterCity;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $city_id = $request->get('city_id', '');
        $query = MasterDistrict::with('city');

        if ($city_id) {
            $query->where('city_id', $city_id);
        }

        $districts = $query->orderBy('name')->paginate(15);
        $cities = MasterCity::all();

        return view('admin.districts.index', compact('districts', 'cities', 'city_id'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $cities = MasterCity::all();
        return view('admin.districts.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'city_id' => 'required|exists:master_cities,id',
            'name' => 'required|string|max:255|unique:master_districts',
            'code' => 'nullable|string|max:10',
        ]);

        MasterDistrict::create($validated);

        return redirect()->route('admin.districts.index')->with('success', 'District created successfully');
    }

    public function edit(MasterDistrict $district)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $cities = MasterCity::all();
        return view('admin.districts.edit', compact('district', 'cities'));
    }

    public function update(Request $request, MasterDistrict $district)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_districts,name,' . $district->id,
            'code' => 'nullable|string|max:10',
        ]);

        $district->update($validated);

        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully');
    }

    public function destroy(MasterDistrict $district)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $district->delete();

        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully');
    }
}

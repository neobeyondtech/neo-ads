<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterSubdistrict;
use App\Models\MasterDistrict;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubdistrictController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $district_id = $request->get('district_id', '');
        $query = MasterSubdistrict::with('district');

        if ($district_id) {
            $query->where('district_id', $district_id);
        }

        $subdistricts = $query->orderBy('name')->paginate(15);
        $districts = MasterDistrict::all();

        return view('admin.subdistricts.index', compact('subdistricts', 'districts', 'district_id'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $districts = MasterDistrict::all();
        return view('admin.subdistricts.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'district_id' => 'required|exists:master_districts,id',
            'name' => 'required|string|max:255|unique:master_subdistricts',
            'postal_code' => 'nullable|string|max:10',
        ]);

        MasterSubdistrict::create($validated);

        return redirect()->route('admin.subdistricts.index')->with('success', 'Subdistrict created successfully');
    }

    public function edit(MasterSubdistrict $subdistrict)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $districts = MasterDistrict::all();
        return view('admin.subdistricts.edit', compact('subdistrict', 'districts'));
    }

    public function update(Request $request, MasterSubdistrict $subdistrict)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_subdistricts,name,' . $subdistrict->id,
            'postal_code' => 'nullable|string|max:10',
        ]);

        $subdistrict->update($validated);

        return redirect()->route('admin.subdistricts.index')->with('success', 'Subdistrict updated successfully');
    }

    public function destroy(MasterSubdistrict $subdistrict)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $subdistrict->delete();

        return redirect()->route('admin.subdistricts.index')->with('success', 'Subdistrict deleted successfully');
    }
}

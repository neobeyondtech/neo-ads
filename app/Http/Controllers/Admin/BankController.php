<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterBank;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $banks = MasterBank::orderBy('name')->paginate(15);

        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_banks',
            'code' => 'required|string|max:10|unique:master_banks',
        ]);

        MasterBank::create($validated);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank created successfully');
    }

    public function edit(MasterBank $bank)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, MasterBank $bank)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:master_banks,name,' . $bank->id,
            'code' => 'required|string|max:10|unique:master_banks,code,' . $bank->id,
        ]);

        $bank->update($validated);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank updated successfully');
    }

    public function destroy(MasterBank $bank)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'masterdata')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $bank->delete();

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank deleted successfully');
    }
}

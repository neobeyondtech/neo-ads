<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\Role;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $role = $request->get('role', '');
        $query = User::query();

        if ($role && $role !== 'all') {
            $query->where('role', Role::tryFrom((int)$role)?->value);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::cases();

        return view('admin.users.index', compact('users', 'roles', 'role'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        $authUser = Auth::user();

        if (!$authUser->role->canPerform('view', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $authUser = Auth::user();

        if (!$authUser->role->canPerform('edit', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $roles = Role::cases();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        if (!$authUser->role->canPerform('edit', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|integer',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();

        if (!$authUser->role->canPerform('delete', 'users')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}

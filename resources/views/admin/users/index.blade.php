@extends('admin.layout')

@section('title', 'Users - Admin')
@section('page-title', 'Users Management')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Users</h2>
        @if(auth()->user()->role->canPerform('create', 'users'))
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex gap-4">
            <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Roles</option>
                @foreach($roles as $r)
                    <option value="{{ $r->value }}" {{ (int)$role === $r->value ? 'selected' : '' }}>{{ $r->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-white text-xs bg-blue-600">
                                {{ $user->role->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->email_verified_at)
                                <span class="px-2 py-1 rounded text-white text-xs bg-green-600">Verified</span>
                            @else
                                <span class="px-2 py-1 rounded text-white text-xs bg-yellow-600">Unverified</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'users'))
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'users'))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this user?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection

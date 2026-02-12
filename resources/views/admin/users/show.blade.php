@extends('admin.layout')

@section('title', 'User Details - Admin')
@section('page-title', 'User Details')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
        <div class="flex gap-2">
            @if(Auth::user()->role->canPerform('edit', 'users'))
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Edit</a>
            @endif
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        {{-- User Info --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800 mb-4">User Information</h3>
            
            <div>
                <p class="text-sm text-gray-600">Name</p>
                <p class="font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Email</p>
                <p class="font-medium">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Role</p>
                <span class="px-2 py-1 rounded text-white text-xs bg-blue-600">
                    {{ $user->role->label() }}
                </span>
            </div>
        </div>

        {{-- Account Status --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800 mb-4">Account Status</h3>
            
            <div>
                <p class="text-sm text-gray-600">Email Verification</p>
                @if($user->email_verified_at)
                    <span class="px-2 py-1 rounded text-white text-xs bg-green-600">Verified - {{ $user->email_verified_at->format('M d, Y') }}</span>
                @else
                    <span class="px-2 py-1 rounded text-white text-xs bg-yellow-600">Unverified</span>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-600">Created At</p>
                <p class="font-medium">{{ $user->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Last Updated</p>
                <p class="font-medium">{{ $user->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

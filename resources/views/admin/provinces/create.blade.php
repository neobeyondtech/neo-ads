@extends('admin.layout')

@section('title', 'Create Province - Admin')
@section('page-title', 'Create Province')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Create New Province</h2>
        <a href="{{ route('admin.provinces.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.provinces.store') }}" class="bg-white rounded-lg border border-gray-200 p-6 space-y-6 max-w-2xl">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Province Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Enter province name" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create Province
            </button>
        </div>
    </form>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Edit Customer - Admin')
@section('page-title', 'Edit Customer')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Edit Customer</h2>
        <a href="{{ route('admin.customers.show', $customer) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="bg-white rounded-lg border border-gray-200 p-6 space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input type="text" name="name" value="{{ $customer->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
            <input type="tel" name="phone" value="{{ $customer->phone }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <textarea name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="3">{{ $customer->address }}</textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Customer
            </button>
        </div>
    </form>
</div>
@endsection

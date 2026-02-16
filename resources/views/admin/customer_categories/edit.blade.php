@extends('admin.layout')

@section('title', 'Edit Customer categorie - Admin')
@section('page-title', 'Edit Customer categorie')

@section('content')
<div class="space-y-6">
    {{-- Header --}} 
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Edit Customer</h2>
        <a href="{{ route('admin.customer_categories.show', $customer_categorie) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.customer_categories.update', $customer_categorie) }}" class="bg-white rounded-lg border border-gray-200 p-6 space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input categorie="text" name="name" value="{{ $customer_categorie->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <button categorie="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Customer categorie
            </button>
        </div>
    </form>
</div>
@endsection

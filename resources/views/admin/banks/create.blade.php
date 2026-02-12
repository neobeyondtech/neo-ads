@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Add Bank</h1>
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Please fix the following errors:</strong>
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.banks.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Bank Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           placeholder="e.g., Bank Central Asia" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="code" class="block text-gray-700 font-semibold mb-2">Bank Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                           placeholder="e.g., BCA" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Create Bank
                    </button>
                    <a href="{{ route('admin.banks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Info</h2>
            <p class="text-gray-600 text-sm">
                Add a new bank to the system. Banks are used for payments and financial transactions. Make sure to provide the official bank name and standardized code.
            </p>
        </div>
    </div>
</div>
@endsection

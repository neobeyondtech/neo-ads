@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit Province</h1>
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
            <form action="{{ route('admin.provinces.update', $province->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Province Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $province->name) }}" 
                           placeholder="e.g., Jawa Barat, Jawa Timur, Sumatera Utara" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Update Province
                    </button>
                    <a href="{{ route('admin.provinces.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Details</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">ID</p>
                    <p class="font-semibold">{{ $province->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Cities Count</p>
                    <p class="font-semibold">{{ $province->cities_count ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Created At</p>
                    <p class="font-semibold">{{ $province->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Updated At</p>
                    <p class="font-semibold">{{ $province->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

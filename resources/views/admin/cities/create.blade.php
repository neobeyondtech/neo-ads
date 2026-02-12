@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Add City</h1>
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
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="province_id" class="block text-gray-700 font-semibold mb-2">Province</label>
                    <select name="province_id" id="province_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Province --</option>
                        @foreach(\App\Models\MasterProvince::all() as $province)
                            <option value="{{ $province->id }}" @if(old('province_id') == $province->id) selected @endif>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">City Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           placeholder="e.g., Jakarta, Bandung, Medan" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Create City
                    </button>
                    <a href="{{ route('admin.cities.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
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
                Add a new city to the system. Cities must belong to a province. Make sure to select the correct province before creating a new city.
            </p>
        </div>
    </div>
</div>
@endsection

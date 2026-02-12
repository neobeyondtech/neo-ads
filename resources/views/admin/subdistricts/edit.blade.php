@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit Subdistrict</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.subdistricts.update', $subdistrict->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">District</label>
            <select name="district_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select --</option>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}" @if($subdistrict->district_id == $district->id) selected @endif>{{ $district->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $subdistrict->name) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Postal Code</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $subdistrict->postal_code) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.subdistricts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection

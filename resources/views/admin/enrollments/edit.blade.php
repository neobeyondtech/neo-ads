@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit Enrollment</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Goal</label>
            <input type="text" name="goal" value="{{ old('goal', $enrollment->goal) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="active" @if($enrollment->status === 'active') selected @endif>Active</option>
                <option value="inactive" @if($enrollment->status === 'inactive') selected @endif>Inactive</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.enrollments.show', $enrollment->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection

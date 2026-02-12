@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Create Report</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.reports.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Partner</label>
            <select name="partner_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select --</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Create</button>
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection

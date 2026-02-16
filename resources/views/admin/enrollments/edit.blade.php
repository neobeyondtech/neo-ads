@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit Enrollment</h1>
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="partner_id" class="block text-gray-700 font-semibold mb-2">Partner *</label>
                        <select name="partner_id" id="partner_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Partner --</option>
                            @foreach(\App\Models\Partner::all() as $partner)
                                <option value="{{ $partner->id }}" {{ old('partner_id', $enrollment->partner_id) == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->first_name }} {{ $partner->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('partner_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="advertisement_id" class="block text-gray-700 font-semibold mb-2">Advertisement *</label>
                        <select name="advertisement_id" id="advertisement_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Advertisement --</option>
                            @foreach(\App\Models\Advertisement::all() as $ad)
                                <option value="{{ $ad->id }}" {{ old('ad_id', $enrollment->advertisement_id) == $ad->id ? 'selected' : '' }}>{{ $ad->title }}</option>
                            @endforeach
                        </select>
                        @error('advertisement_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Status *</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="pending" {{ old('status', $enrollment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $enrollment->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $enrollment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ old('status', $enrollment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="rate" class="block text-gray-700 font-semibold mb-2">Rate</label>
                        <input type="number" name="rate" id="rate" value="{{ old('rate', $enrollment->rate) }}" step="0.01"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('rate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $enrollment->start_date ? $enrollment->start_date->format('Y-m-d') : '') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $enrollment->end_date ? $enrollment->end_date->format('Y-m-d') : '') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="remarks" class="block text-gray-700 font-semibold mb-2">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('remarks', $enrollment->remarks) }}</textarea>
                    @error('remarks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="achievement" class="block text-gray-700 font-semibold mb-2">Achievement</label>
                    <textarea name="achievement" id="achievement" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('achievement', $enrollment->achievement) }}</textarea>
                    @error('achievement')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Update Enrollment
                    </button>
                    <a href="{{ route('admin.enrollments.show', $enrollment->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Enrollment Metadata</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">ID</p>
                    <p class="font-semibold">{{ $enrollment->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Approved At</p>
                    <p class="font-semibold">{{ $enrollment->approved_at ? \Carbon\Carbon::parse($enrollment->approved_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Rejected At</p>
                    <p class="font-semibold">{{ $enrollment->rejected_at ? \Carbon\Carbon::parse($enrollment->rejected_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Completed At</p>
                    <p class="font-semibold">{{ $enrollment->completed_at ? \Carbon\Carbon::parse($enrollment->completed_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
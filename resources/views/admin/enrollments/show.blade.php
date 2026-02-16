@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Enrollment Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'enrollments'))
        <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            Edit
        </a>
    @endif
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Enrollment Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">ID</p>
                    <p class="font-semibold">{{ $enrollment->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Partner</p>
                    <p class="font-semibold">{{ $enrollment->partner?->first_name ?? '' }} {{ $enrollment->partner?->last_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Advertisement</p>
                    <p class="font-semibold">{{ $enrollment->advertisement?->title ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status</p>
                    <p class="font-semibold">
                        <span class="px-2 py-1 rounded text-white text-xs
                            @if($enrollment->status === 'approved') bg-green-600
                            @elseif($enrollment->status === 'pending') bg-yellow-600
                            @elseif($enrollment->status === 'rejected') bg-red-600
                            @elseif($enrollment->status === 'completed') bg-blue-600
                            @else bg-gray-600
                            @endif
                        ">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Rate</p>
                    <p class="font-semibold">{{ $enrollment->rate ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Start Date</p>
                    <p class="font-semibold">{{ $enrollment->start_date ? \Carbon\Carbon::parse($enrollment->start_date)->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">End Date</p>
                    <p class="font-semibold">{{ $enrollment->end_date ? \Carbon\Carbon::parse($enrollment->end_date)->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Approved At</p>
                    <p class="font-semibold">{{ $enrollment->approved_at ? \Carbon\Carbon::parse($enrollment->approved_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Rejected At</p>
                    <p class="font-semibold">{{ $enrollment->rejected_at ? \Carbon\Carbon::parse($enrollment->rejected_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Completed At</p>
                    <p class="font-semibold">{{ $enrollment->completed_at ? \Carbon\Carbon::parse($enrollment->completed_at)->format('d M Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Remarks</h2>
            <p class="text-gray-700 whitespace-pre-line">{{ $enrollment->remarks ?? 'No remarks' }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Achievement</h2>
            <p class="text-gray-700 whitespace-pre-line">{{ $enrollment->achievement ?? 'No achievement notes' }}</p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Actions</h2>
            <div class="space-y-2">
                @if(auth()->user()->role->canPerform('edit', 'enrollments'))
                    <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                        Edit Enrollment
                    </a>
                @endif
                @if(auth()->user()->role->canPerform('delete', 'enrollments'))
                    <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                            Delete Enrollment
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.enrollments.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
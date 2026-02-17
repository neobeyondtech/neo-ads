@extends('admin.layout')

@section('title', 'Enrollments - Admin')
@section('page-title', 'Enrollments')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Enrollments</h2>
        @if(auth()->user()->role->canPerform('create', 'enrollments'))
            <a href="{{ route('admin.enrollments.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Add Enrollment</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.enrollments.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex flex-wrap gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Partner</th>
                    <th class="px-4 py-3 text-left">Advertisement</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Start Date</th>
                    <th class="px-4 py-3 text-left">End Date</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $enrollment->id }}</td>
                        <td class="px-4 py-3">{{ $enrollment->partner?->first_name ?? 'N/A' }} {{ $enrollment->partner?->last_name ?? '' }}</td>
                        <td class="px-4 py-3">{{ $enrollment->advertisement?->title ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
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
                        </td>
                        <td class="px-4 py-3">{{ $enrollment->start_date ? \Carbon\Carbon::parse($enrollment->start_date)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3">{{ $enrollment->enddate ? \Carbon\Carbon::parse($enrollment->end_date)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'enrollments'))
                                    <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No enrollments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $enrollments->links() }}
    </div>
</div>
@endsection
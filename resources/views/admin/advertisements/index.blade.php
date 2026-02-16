@extends('admin.layout')

@section('title', 'Advertisements - Admin')
@section('page-title', 'Advertisements')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Advertisements</h2>
        @if(auth()->user()->role->canPerform('create', 'advertisements'))
            <a href="{{ route('admin.advertisements.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.advertisements.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ $status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Customer</th>
                    <th class="px-4 py-3 text-left">City</th>
                    <th class="px-4 py-3 text-left">Goal</th>
                    <th class="px-4 py-3 text-left">Target Location</th>
                    <th class="px-4 py-3 text-left">Target Distance</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Duration</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Budget</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advertisements as $ad)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $ad->title }}</td>
                        <td class="px-4 py-3">{{ $ad->customer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $ad->city->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $ad->goal_type ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $ad->target_location_id ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $ad->target_distance ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($ad->status === 'draft') bg-gray-500
                                @elseif($ad->status === 'active') bg-green-500
                                @elseif($ad->status === 'completed') bg-blue-500
                                @else bg-red-500
                                @endif
                            ">
                                {{ ucfirst($ad->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $ad->duration ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $ad->description ?? 'N/A' }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($ad->total_budget, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $ad->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.advertisements.show', $ad) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'advertisements'))
                                    <a href="{{ route('admin.advertisements.edit', $ad) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'advertisements'))
                                    <form method="POST" action="{{ route('admin.advertisements.destroy', $ad) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this advertisement?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No advertisements found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $advertisements->links() }}
    </div>
</div>
@endsection

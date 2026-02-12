@extends('admin.layout')

@section('title', 'Partners - Admin')
@section('page-title', 'Partners')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Partners</h2>
        @if(auth()->user()->role->canPerform('create', 'partners'))
            <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.partners.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex gap-4">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                @foreach($statuses as $st)
                    <option value="{{ $st['value'] }}" {{ (int)$status === $st['value'] ? 'selected' : '' }}>{{ $st['label'] }}</option>
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
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Vehicles</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $partner->name }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($partner->status === 'active') bg-green-600
                                @elseif($partner->status === 'pending') bg-yellow-600
                                @else bg-red-600
                                @endif
                            ">
                                {{ ucfirst($partner->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $partner->vehicles_count ?? 0 }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $partner->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.partners.show', $partner) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'partners'))
                                    <a href="{{ route('admin.partners.edit', $partner) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No partners found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $partners->links() }}
    </div>
</div>
@endsection

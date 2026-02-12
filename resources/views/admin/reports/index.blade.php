@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Reports</h1>
    @if(auth()->user()->role->canPerform('create', 'reports'))
        <a href="{{ route('admin.reports.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add</a>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Partner</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Created</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($reports as $report)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $report->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $report->title }}</td>
                    <td class="px-6 py-3 text-sm">{{ $report->partner?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm"><span class="px-2 py-1 rounded text-xs font-semibold @if($report->status === 'completed') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">{{ ucfirst($report->status) }}</span></td>
                    <td class="px-6 py-3 text-sm">{{ $report->created_at?->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-500 hover:underline">View</a>
                        @if(auth()->user()->role->canPerform('edit', 'reports'))
                            <a href="{{ route('admin.reports.edit', $report->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'reports'))
                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No reports found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($reports->hasPages())
    <div class="mt-6">{{ $reports->links() }}</div>
@endif
@endsection

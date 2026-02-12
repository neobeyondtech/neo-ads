@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Enrollments</h1>
    @if(auth()->user()->role->canPerform('create', 'enrollments'))
        <a href="{{ route('admin.enrollments.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add</a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Customer</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Goal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Created</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($enrollments as $enrollment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $enrollment->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $enrollment->customer?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $enrollment->goal ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm"><span class="px-2 py-1 rounded text-xs font-semibold @if($enrollment->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">{{ ucfirst($enrollment->status) }}</span></td>
                    <td class="px-6 py-3 text-sm">{{ $enrollment->created_at?->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.enrollments.show', $enrollment->id) }}" class="text-blue-500 hover:underline">View</a>
                        @if(auth()->user()->role->canPerform('edit', 'enrollments'))
                            <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'enrollments'))
                            <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No enrollments found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($enrollments->hasPages())
    <div class="mt-6">{{ $enrollments->links() }}</div>
@endif
@endsection

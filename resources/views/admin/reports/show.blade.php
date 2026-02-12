@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Report Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'reports'))
        <a href="{{ route('admin.reports.edit', $report->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-lg mb-4">{{ $report->title }}</h3>
        <div class="space-y-2 text-sm">
            <p><span class="text-gray-600">Partner:</span> {{ $report->partner?->name ?? 'N/A' }}</p>
            <p><span class="text-gray-600">Description:</span> {{ $report->description ?? '-' }}</p>
            <p><span class="text-gray-600">Created:</span> {{ $report->created_at?->format('d M Y') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold @if($report->status === 'completed') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">{{ ucfirst($report->status) }}</span>
        <div class="mt-4 space-y-2">
            @if(auth()->user()->role->canPerform('edit', 'reports'))
                <a href="{{ route('admin.reports.edit', $report->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">Edit</a>
            @endif
            @if(auth()->user()->role->canPerform('delete', 'reports'))
                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Sure?')" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">Delete</button>
                </form>
            @endif
            <a href="{{ route('admin.reports.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded">Back</a>
        </div>
    </div>
</div>
@endsection

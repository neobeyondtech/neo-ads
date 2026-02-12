@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Enrollment Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'enrollments'))
        <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-600">ID</p><p class="font-semibold">{{ $enrollment->id }}</p></div>
                <div><p class="text-gray-600">Customer</p><p class="font-semibold">{{ $enrollment->customer?->name ?? 'N/A' }}</p></div>
                <div><p class="text-gray-600">Goal</p><p class="font-semibold">{{ $enrollment->goal ?? '-' }}</p></div>
                <div><p class="text-gray-600">Created</p><p class="font-semibold">{{ $enrollment->created_at?->format('d M Y') }}</p></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold @if($enrollment->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">{{ ucfirst($enrollment->status) }}</span>
        <div class="mt-4 space-y-2">
            @if(auth()->user()->role->canPerform('edit', 'enrollments'))
                <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">Edit</a>
            @endif
            @if(auth()->user()->role->canPerform('delete', 'enrollments'))
                <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Sure?')" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">Delete</button>
                </form>
            @endif
            <a href="{{ route('admin.enrollments.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded">Back</a>
        </div>
    </div>
</div>
@endsection

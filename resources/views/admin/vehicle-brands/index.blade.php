@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Vehicle Brands</h1>
    @if(auth()->user()->role->canPerform('create', 'masterdata'))
        <a href="{{ route('admin.vehicle-brands.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
            + Add Brand
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created At</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($brands as $brand)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $brand->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $brand->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $brand->created_at?->format('d M Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.vehicle-brands.edit', $brand->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @if(auth()->user()->role->canPerform('delete', 'masterdata'))
                            <form action="{{ route('admin.vehicle-brands.destroy', $brand->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        No vehicle brands found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($brands->hasPages())
    <div class="mt-6">
        {{ $brands->links() }}
    </div>
@endif
@endsection

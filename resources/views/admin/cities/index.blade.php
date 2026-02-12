@extends('admin.layout')

@section('title', 'Cities - Admin')
@section('page-title', 'Cities')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Cities</h2>
        <a href="{{ route('admin.cities.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Add City
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">City Name</th>
                    <th class="px-4 py-3 text-left">Province</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $city->name }}</td>
                        <td class="px-4 py-3">{{ $city->province->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                @if(Auth::user()->role->canPerform('edit', 'masterdata'))
                                    <a href="{{ route('admin.cities.edit', $city) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'masterdata'))
                                    <form method="POST" action="{{ route('admin.cities.destroy', $city) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this city?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">No cities found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $cities->links() }}
    </div>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Provinces - Admin')
@section('page-title', 'Provinces')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Provinces</h2>
        <a href="{{ route('admin.provinces.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Add Province
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Cities</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($provinces as $province)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $province->name }}</td>
                        <td class="px-4 py-3">{{ $province->cities_count ?? 0 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                @if(Auth::user()->role->canPerform('edit', 'masterdata'))
                                    <a href="{{ route('admin.provinces.edit', $province) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'masterdata'))
                                    <form method="POST" action="{{ route('admin.provinces.destroy', $province) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this province?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">No provinces found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $provinces->links() }}
    </div>
</div>
@endsection

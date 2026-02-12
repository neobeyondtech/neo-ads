@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Districts</h1>
    @if(auth()->user()->role->canPerform('create', 'masterdata'))
        <a href="{{ route('admin.districts.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add</a>
    @endif
</div>

<div class="mb-4 bg-white rounded-lg shadow p-4">
    <form method="GET" class="flex gap-2">
        <select name="city_id" class="border border-gray-300 rounded px-3 py-2" onchange="this.form.submit()">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" @if($city_id == $city->id) selected @endif>{{ $city->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">City</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Code</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($districts as $district)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $district->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $district->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $district->city?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $district->code ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        @if(auth()->user()->role->canPerform('edit', 'masterdata'))
                            <a href="{{ route('admin.districts.edit', $district->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'masterdata'))
                            <form action="{{ route('admin.districts.destroy', $district->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No districts found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($districts->hasPages())
    <div class="mt-6">{{ $districts->links() }}</div>
@endif
@endsection

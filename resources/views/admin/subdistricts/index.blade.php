@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Subdistricts</h1>
    @if(auth()->user()->role->canPerform('create', 'masterdata'))
        <a href="{{ route('admin.subdistricts.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">+ Add</a>
    @endif
</div>

<div class="mb-4 bg-white rounded-lg shadow p-4">
    <form method="GET" class="flex gap-2">
        <select name="district_id" class="border border-gray-300 rounded px-3 py-2" onchange="this.form.submit()">
            <option value="">All Districts</option>
            @foreach($districts as $district)
                <option value="{{ $district->id }}" @if($district_id == $district->id) selected @endif>{{ $district->name }}</option>
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
                <th class="px-6 py-3 text-left text-sm font-semibold">District</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Postal Code</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($subdistricts as $subdist)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $subdist->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $subdist->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $subdist->district?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $subdist->postal_code ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        @if(auth()->user()->role->canPerform('edit', 'masterdata'))
                            <a href="{{ route('admin.subdistricts.edit', $subdist->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'masterdata'))
                            <form action="{{ route('admin.subdistricts.destroy', $subdist->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No subdistricts found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($subdistricts->hasPages())
    <div class="mt-6">{{ $subdistricts->links() }}</div>
@endif
@endsection

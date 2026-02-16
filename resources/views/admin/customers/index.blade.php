@extends('admin.layout')

@section('title', 'Customers - Admin')
@section('page-title', 'Customers')

@section('content')
<div class="space-y-6">
    {{-- Header --}} 
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Customers</h2>
        @if(auth()->user()->role->canPerform('create', 'customers'))
            <a href="{{ route('admin.customers.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.customers.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Search</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-left">NPWP</th>
                    <th class="px-4 py-3 text-left">Province</th>
                    <th class="px-4 py-3 text-left">District</th>
                    <th class="px-4 py-3 text-left">Sub Distict</th>
                    <th class="px-4 py-3 text-left">City</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Phone</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->type->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->province->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->district->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->subdistrict->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->city->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->NPWP_number ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $customer->user->email ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $customer->phone ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $customer->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'customers'))
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'customers'))
                                    <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this customer?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $customers->links() }}
    </div>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Customer categories - Admin')
@section('page-title', 'Customer categories')

@section('content')
<div class="space-y-6">
    {{-- Header --}} 
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All Customer_categories</h2>
        @if(auth()->user()->role->canPerform('create', 'customer_categories'))
            <a href="{{ route('admin.customer_categories.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

   

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer_categorie as $categorie)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $categorie->name }}</td>
                          <td class="px-4 py-3 text-gray-600">{{ $categorie->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.customer_categories.show', $categorie->id) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'customer_categories'))
                                    <a href="{{ route('admin.customer_categories.edit', $categorie->id) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                                @if(Auth::user()->role->canPerform('delete', 'customer_categories'))
                                    <form method="POST" action="{{ route('admin.customer_categories.destroy', $categorie->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button categorie="submit" onclick="return confirm('Delete this customer?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No customer_categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $customer_categorie->links() }}
    </div>
</div>
@endsection

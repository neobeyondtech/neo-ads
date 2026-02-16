@extends('admin.layout')

@section('title', 'Customer Type Details - Admin')
@section('page-title', 'Customer Type Details')

@section('content')
<div class="space-y-6">
    {{-- Header --}} 
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">{{ $customer_type->name }}</h2>
        <div class="flex gap-2">
            @if(Auth::user()->role->canPerform('edit', 'customer_types'))
                <a href="{{ route('admin.customer_types.edit', $customer_type->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Edit</a>
            @endif
            <a href="{{ route('admin.customer_types.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        {{-- Customer Info --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800 mb-4">Customer Type Information</h3>
            
            <div>
                <p class="text-sm text-gray-600">Name</p>
                <p class="font-medium">{{ $customer_type->name }}</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <h3 class="font-semibold text-gray-800 mb-4">Statistics</h3>
            
            <div>
                <p class="text-sm text-gray-600">Total Advertisements</p>
                <p class="text-lg font-bold text-blue-600">{{ $customer_type->advertisements_count ?? 0 }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Transactions</p>
                <p class="text-lg font-bold text-green-600">{{ $customer_type->transactions_count ?? 0 }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Created At</p>
                <p class="font-medium">{{ $customer_type->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

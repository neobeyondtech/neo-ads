@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Transaction Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'transactions'))
        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            Edit
        </a>
    @endif
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Transaction Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Transaction ID</p>
                    <p class="font-semibold">{{ $transaction->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Advertisement</p>
                    <p class="font-semibold">
                        @if($transaction->advertisement)
                            <a href="{{ route('admin.advertisements.show', $transaction->advertisement->id) }}" class="text-blue-500 hover:underline">
                                {{ $transaction->advertisement->title }}
                            </a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Amount</p>
                    <p class="font-semibold">Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-semibold">{{ $transaction->payment_method ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Reference</p>
                    <p class="font-semibold">{{ $transaction->payment_reference ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Created At</p>
                    <p class="font-semibold">{{ $transaction->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Notes</h2>
            <p class="text-gray-700">{{ $transaction->notes ?? 'No additional notes' }}</p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Status</h2>
            <div class="mb-4">
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    @if($transaction->payment_status === 'paid')
                        bg-green-100 text-green-800
                    @elseif($transaction->payment_status === 'pending')
                        bg-yellow-100 text-yellow-800
                    @elseif($transaction->payment_status === 'failed')
                        bg-red-100 text-red-800
                    @elseif($transaction->payment_status === 'cancelled')
                        bg-gray-100 text-gray-800
                    @else
                        bg-blue-100 text-blue-800
                    @endif">
                    {{ ucfirst($transaction->payment_status ?? 'unknown') }}
                </span>
            </div>

            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Updated At</p>
                    <p class="font-semibold">{{ $transaction->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                <div class="border-t pt-3 mt-3">
                    <p class="text-gray-600 text-sm mb-2">Actions</p>
                    <div class="space-y-2">
                        @if(auth()->user()->role->canPerform('edit', 'transactions'))
                            <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                                Edit Transaction
                            </a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'transactions'))
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                    Delete Transaction
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.transactions.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

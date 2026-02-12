@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit Transaction</h1>
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Please fix the following errors:</strong>
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="payment_status" class="block text-gray-700 font-semibold mb-2">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending" @if($transaction->payment_status === 'pending') selected @endif>Pending</option>
                        <option value="paid" @if($transaction->payment_status === 'paid') selected @endif>Paid</option>
                        <option value="failed" @if($transaction->payment_status === 'failed') selected @endif>Failed</option>
                        <option value="cancelled" @if($transaction->payment_status === 'cancelled') selected @endif>Cancelled</option>
                    </select>
                    @error('payment_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($methods as $method)
                            <option value="{{ $method['value'] }}" @if($transaction->payment_method === $method['value']) selected @endif>
                                {{ $method['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="payment_reference" class="block text-gray-700 font-semibold mb-2">Payment Reference</label>
                    <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference', $transaction->payment_reference) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('payment_reference')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-gray-700 font-semibold mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $transaction->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Update Transaction
                    </button>
                    <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Transaction Details</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">ID</p>
                    <p class="font-semibold">{{ $transaction->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Amount</p>
                    <p class="font-semibold">Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Advertisement</p>
                    <p class="font-semibold">
                        @if($transaction->advertisement)
                            {{ $transaction->advertisement->title }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div class="border-t pt-3 mt-3">
                    <p class="text-gray-600 text-sm">Created At</p>
                    <p class="font-semibold">{{ $transaction->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

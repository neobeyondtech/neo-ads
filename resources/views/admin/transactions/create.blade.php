@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Create Transaction</h1>
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
            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="advertisement_id" class="block text-gray-700 font-semibold mb-2">Advertisement</label>
                    <select name="advertisement_id" id="advertisement_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Advertisement --</option>
                        @foreach(\App\Models\Advertisement::all() as $ad)
                            <option value="{{ $ad->id }}">{{ $ad->title }}</option>
                        @endforeach
                    </select>
                    @error('advertisement_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-semibold mb-2">Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" 
                           step="0.01" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="payment_reference" class="block text-gray-700 font-semibold mb-2">Payment Reference</label>
                    <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('payment_reference')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="payment_status" class="block text-gray-700 font-semibold mb-2">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    @error('payment_status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-gray-700 font-semibold mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Create Transaction
                    </button>
                    <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Info</h2>
            <p class="text-gray-600 text-sm">
                Record a new transaction. Link it to an advertisement and enter payment details and status.
            </p>
        </div>
    </div>
</div>
@endsection

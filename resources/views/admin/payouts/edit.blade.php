@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Edit payout</h1>
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
            <form action="{{ route('admin.payouts.update', $payout->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="advertisement_id" class="block text-gray-700 font-semibold mb-2">Advertisement *</label>
                        <select name="advertisement_id" id="advertisement_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Advertisement --</option>
                            @foreach(\App\Models\Advertisement::all() as $ad)
                                <option value="{{ $ad->id }}" {{ old('ad_id', $payout->advertisement_id) == $ad->id ? 'selected' : '' }}>{{ $ad->title }}</option>
                            @endforeach
                        </select>
                        @error('advertisement_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="partner_id" class="block text-gray-700 font-semibold mb-2">Partner *</label>
                        <select name="partner_id" id="partner_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Select Partner --</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" {{ old('partner_id', $payout->partner_id) == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->first_name }} {{ $partner->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('partner_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-semibold mb-2">Amount *</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $payout->amount) }}" 
                               step="0.01" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                        <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $payout->payment_method) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="payment_channel" class="block text-gray-700 font-semibold mb-2">Payment Channel</label>
                        <input type="text" name="payment_channel" id="payment_channel" value="{{ old('payment_channel', $payout->payment_channel) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('payment_channel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="transaction_reference" class="block text-gray-700 font-semibold mb-2">payout Reference</label>
                        <input type="text" name="transaction_reference" id="transaction_reference" value="{{ old('transaction_reference', $payout->transaction_reference) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('payout_reference')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="payment_date" class="block text-gray-700 font-semibold mb-2">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $payout->payment_date ? $payout->payment_date->format('Y-m-d') : '') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('payment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="payment_status" class="block text-gray-700 font-semibold mb-2">Payment Status *</label>
                        <select name="payment_status" id="payment_status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="pending" {{ old('payment_status', $payout->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status', $payout->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ old('payment_status', $payout->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="cancelled" {{ old('payment_status', $payout->payment_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('payment_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="payment_notes" class="block text-gray-700 font-semibold mb-2">Payment Notes</label>
                    <textarea name="payment_notes" id="payment_notes" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('payment_notes', $payout->payment_notes) }}</textarea>
                    @error('payment_notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Update payout
                    </button>
                    <a href="{{ route('admin.payouts.show', $payout->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">payout Metadata</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">ID</p>
                    <p class="font-semibold">{{ $payout->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Created At</p>
                    <p class="font-semibold">{{ $payout->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Updated At</p>
                    <p class="font-semibold">{{ $payout->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
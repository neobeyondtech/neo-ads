@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">payout Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'payouts'))
        <a href="{{ route('admin.payouts.edit', $payout->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
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
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">payout Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">payout ID</p>
                    <p class="font-semibold">{{ $payout->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Advertisement</p>
                    <p class="font-semibold">{{ $payout->advertisement?->title ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Partner</p>
                    <p class="font-semibold">{{ $payout->partner?->first_name ?? '' }} {{ $payout->partner?->last_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Amount</p>
                    <p class="font-semibold">{{ number_format($payout->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Status</p>
                    <p class="font-semibold">
                        <span class="px-2 py-1 rounded text-white text-xs
                            @if($payout->payment_status === 'paid') bg-green-600
                            @elseif($payout->payment_status === 'pending') bg-yellow-600
                            @elseif($payout->payment_status === 'failed') bg-red-600
                            @else bg-gray-600
                            @endif
                        ">
                            {{ ucfirst($payout->payment_status) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-semibold">{{ $payout->payment_method ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Channel</p>
                    <p class="font-semibold">{{ $payout->payment_channel ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">payout Reference</p>
                    <p class="font-semibold">{{ $payout->transaction_reference ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Date</p>
                    <p class="font-semibold">{{ $payout->payment_date ? \Carbon\Carbon::parse($payout->payment_date)->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Created At</p>
                    <p class="font-semibold">{{ $payout->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Payment Notes</h2>
            <p class="text-gray-700 whitespace-pre-line">{{ $payout->payment_notes ?? 'No notes provided' }}</p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Metadata</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Updated At</p>
                    <p class="font-semibold">{{ $payout->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                @if($payout->deleted_at)
                <div>
                    <p class="text-gray-600 text-sm">Deleted At</p>
                    <p class="font-semibold text-red-600">{{ $payout->deleted_at->format('d M Y H:i') }}</p>
                </div>
                @endif
                <div class="border-t pt-3 mt-3">
                    <p class="text-gray-600 text-sm mb-2">Actions</p>
                    <div class="space-y-2">
                        @if(auth()->user()->role->canPerform('edit', 'payouts'))
                            <a href="{{ route('admin.payouts.edit', $payout->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                                Edit payout
                            </a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'payouts'))
                            <form action="{{ route('admin.payouts.destroy', $payout->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                    Delete payout
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.payouts.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layout')

@section('title', 'payouts - Admin')
@section('page-title', 'payouts')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">All payouts</h2>
        @if(auth()->user()->role->canPerform('create', 'payouts'))
            <a href="{{ route('admin.payouts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Create</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back to Dashboard</a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.payouts.index') }}" class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex flex-wrap gap-4">
            <select name="payment_status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Advertisement</th>
                    <th class="px-4 py-3 text-left">Partner</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Payment Method</th>
                    <th class="px-4 py-3 text-left">payout Ref</th>
                    <th class="px-4 py-3 text-left">Payment Date</th>
                    <th class="px-4 py-3 text-left">Created</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payouts as $payout)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $payout->id }}</td>
                        <td class="px-4 py-3">{{ $payout->advertisement?->title ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $payout->partner?->first_name ?? 'N/A' }} {{ $payout->partner?->last_name ?? '' }}</td>
                        <td class="px-4 py-3">{{ number_format($payout->amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($payout->payment_status === 'paid') bg-green-600
                                @elseif($payout->payment_status === 'pending') bg-yellow-600
                                @elseif($payout->payment_status === 'failed') bg-red-600
                                @else bg-gray-600
                                @endif
                            ">
                                {{ ucfirst($payout->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $payout->payment_method ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $payout->payout_reference ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $payout->payment_date ? \Carbon\Carbon::parse($payout->payment_date)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $payout->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.payouts.show', $payout) }}" class="text-blue-600 hover:underline">View</a>
                                @if(Auth::user()->role->canPerform('edit', 'payouts'))
                                    <a href="{{ route('admin.payouts.edit', $payout) }}" class="text-green-600 hover:underline">Edit</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">No payouts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $payouts->links() }}
    </div>
</div>
@endsection
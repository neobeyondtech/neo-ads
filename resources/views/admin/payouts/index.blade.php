@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Payouts</h1>
    @if(auth()->user()->role->canPerform('create', 'payouts'))
        <a href="{{ route('admin.payouts.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
            + Add Payout
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Partner</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created At</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($payouts as $payout)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $payout->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $payout->partner?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">Rp {{ number_format($payout->amount ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                            @if($payout->status === 'paid')
                                bg-green-100 text-green-800
                            @elseif($payout->status === 'pending')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($payout->status ?? 'unknown') }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm">{{ $payout->created_at?->format('d M Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.payouts.show', $payout->id) }}" class="text-blue-500 hover:underline">View</a>
                        @if(auth()->user()->role->canPerform('edit', 'payouts'))
                            <a href="{{ route('admin.payouts.edit', $payout->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'payouts'))
                            <form action="{{ route('admin.payouts.destroy', $payout->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No payouts found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($payouts->hasPages())
    <div class="mt-6">
        {{ $payouts->links() }}
    </div>
@endif
@endsection

@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Payout Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'payouts'))
        <a href="{{ route('admin.payouts.edit', $payout->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-600">ID</p><p class="font-semibold">{{ $payout->id }}</p></div>
                <div><p class="text-gray-600">Partner</p><p class="font-semibold">{{ $payout->partner?->name ?? 'N/A' }}</p></div>
                <div><p class="text-gray-600">Amount</p><p class="font-semibold">Rp {{ number_format($payout->amount, 0, ',', '.') }}</p></div>
                <div><p class="text-gray-600">Created</p><p class="font-semibold">{{ $payout->created_at?->format('d M Y') }}</p></div>
            </div>
            <div class="mt-4"><p class="text-gray-600">Notes</p><p>{{ $payout->notes ?? '-' }}</p></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
            @if($payout->status === 'paid') bg-green-100 text-green-800
            @elseif($payout->status === 'pending') bg-yellow-100 text-yellow-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ ucfirst($payout->status) }}
        </span>
        <div class="mt-4 space-y-2">
            @if(auth()->user()->role->canPerform('edit', 'payouts'))
                <a href="{{ route('admin.payouts.edit', $payout->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">Edit</a>
            @endif
            @if(auth()->user()->role->canPerform('delete', 'payouts'))
                <form action="{{ route('admin.payouts.destroy', $payout->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Sure?')" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">Delete</button>
                </form>
            @endif
            <a href="{{ route('admin.payouts.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded">Back</a>
        </div>
    </div>
</div>
@endsection

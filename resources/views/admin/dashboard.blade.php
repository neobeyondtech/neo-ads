@extends('admin.layout')

@section('title', 'Admin Dashboard - NeoAds')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Advertisements --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Advertisements</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalAdvertisements }}</p>
            </div>
            <div class="text-4xl text-blue-100">📢</div>
        </div>
    </div>

    {{-- Total Customers --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Customers</p>
                <p class="text-3xl font-bold text-green-600">{{ $totalCustomers }}</p>
            </div>
            <div class="text-4xl text-green-100">👥</div>
        </div>
    </div>

    {{-- Total Partners --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Partners</p>
                <p class="text-3xl font-bold text-purple-600">{{ $totalPartners }}</p>
            </div>
            <div class="text-4xl text-purple-100">🚗</div>
        </div>
    </div>

    {{-- Total Transactions --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Transactions</p>
                <p class="text-2xl font-bold text-orange-600">Rp{{ number_format($totalTransactions, 0, ',', '.') }}</p>
            </div>
            <div class="text-4xl text-orange-100">💰</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Advertisements --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Advertisements</h3>
        <div class="space-y-3">
            @forelse($recentAdvertisements as $ad)
                <div class="pb-3 border-b border-gray-200 last:border-0">
                    <p class="font-medium text-gray-800">{{ $ad->title }}</p>
                    <p class="text-sm text-gray-600">{{ $ad->customer->name ?? 'Unknown' }} - {{ $ad->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No advertisements yet</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h3>
        <div class="space-y-3">
            @forelse($recentTransactions as $transaction)
                <div class="pb-3 border-b border-gray-200 last:border-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">{{ $transaction->advertisement->title ?? 'Unknown' }}</p>
                            <p class="text-sm text-gray-600">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($transaction->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($transaction->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif
                        ">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No transactions yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

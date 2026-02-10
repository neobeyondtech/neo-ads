@extends('layout.app')

@section('title', 'Pembayaran - NeoAds')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <h1 class="text-4xl font-semibold text-gray-500">Pembayaran</h1>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ================= KIRI (TABLE) ================= --}}
        <div class="xl:col-span-2 space-y-4">

            {{-- Tabs --}}
            <div class="flex gap-2">
                <a href="{{ route('my-payment.index') }}"
                class="px-4 py-2 rounded-full text-sm font-medium
                {{ request('tab') != 'berjalan'
                        ? 'bg-blue-900 text-white'
                        : 'border text-gray-600 hover:bg-gray-100' }}">
                    Semua Pembayaran
                </a>

                <a href="{{ route('my-payment.index', ['tab' => 'berjalan']) }}"
                class="px-4 py-2 rounded-full text-sm font-medium
                {{ request('tab') == 'berjalan'
                        ? 'bg-blue-900 text-white'
                        : 'border text-gray-600 hover:bg-gray-100' }}">
                    Pembayaran Berjalan
                </a>
            </div>


            {{-- Table --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Judul Iklan</th>
                            <th class="px-4 py-3 text-left">XXX</th>
                            <th class="px-4 py-3 text-left">Biaya</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $item)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-3">{{ $item->iklan->judul_iklan ?? '-' }}</td>
                            <td class="px-4 py-3">XXX</td>
                            <td class="px-4 py-3 text-red-600 font-medium">
                                -Rp{{ number_format($item->jumlah,0,',','.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $item->status }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="flex justify-between items-center px-4 py-3 text-sm text-gray-500">
                    <span>Showing 10 from 12 data</span>
                    <div class="flex gap-1">
                        <button class="px-3 py-1 bg-blue-900 text-white rounded">1</button>
                        <button class="px-3 py-1 border rounded">2</button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ================= KANAN (SALDO) ================= --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-6 ">

            {{-- Saldo --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-1">
                    Saldo Deposit
                </h3>
                <p class="text-3xl font-bold text-blue-700">
                    Rp{{ number_format($saldoAkhir,0,',','.') }}
                </p>
            </div>

            {{-- Action --}}
            <div class="flex items-center gap-3">
                {{-- ICON KOTAK --}}
                <div class="w-10 h-10 flex items-center justify-center
                            border rounded-md text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <circle cx="12" cy="12" r="3" />
                        <path d="M6 12h.01M18 12h.01" />
                    </svg>
                </div>

                {{-- TOMBOL --}}
                <button class="btn-primary px-4 py-2 text-sm font-medium">
                    + Tambah Deposit
                </button>
            </div>

            <hr>

            {{-- Riwayat --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-600 mb-3">
                    Riwayat Deposit
                </h4>

                <div class="space-y-2 text-sm">
                    @foreach($riwayatDeposit as $deposit)
                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            {{ \Carbon\Carbon::parse($deposit->tanggal_transaksi)->translatedFormat('d F Y') }}
                        </span>
                        <span class="text-green-600 font-medium">
                            +Rp{{ number_format($deposit->jumlah,0,',','.') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
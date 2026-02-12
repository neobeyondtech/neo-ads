@extends('layout.app')

@section('title', 'Detail Iklan - NeoAds')

@section('content')
<div class="grid grid-cols-3 gap-6 max-w-7xl">
    {{-- LEFT SIDE - MAIN CONTENT --}}
    <div class="col-span-2 bg-white rounded-lg border border-gray-200 p-8">

        {{-- INFORMASI IKLAN --}}
        <h1 class="text-2xl font-bold text-gray-400 mb-6">
            Informasi Iklan
        </h1>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="label">Nama Iklan</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->title }}" readonly>
            </div>

            <div>
                <label class="label">Tujuan Iklan</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->goal_type_label }}" readonly>
            </div>
            
            <div>
                <label class="label">Target Lokasi Iklan</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->targetLocation->name ?? 'Tidak Diketahui' }}" readonly>
            </div>

            <div>
                <label class="label">Lokasi Stiker</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->sticker_area_type_label }}" readonly>
            </div>

            <div>
                <label class="label">Target Jumlah Partner</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->target_partner ?? 'Tidak Diketahui' }}" readonly>
            </div>

            <div>
                <label class="label">Target Eksposur Tercapai (KM)</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ number_format($advertisement->target_distance) }}" readonly>
            </div>

            <div>
                <label class="label">Tanggal Iklan Dimulai</label>
                <input type="date" class="input bg-gray-100"
                       value="{{ $advertisement->startdate ? \Carbon\Carbon::parse($advertisement->startdate)->format('Y-m-d') : '' }}" readonly>
            </div>

            <div>
                <label class="label">Tanggal Iklan Berakhir</label>
                <input type="date" class="input bg-gray-100"
                       value="{{ $advertisement->enddate ? \Carbon\Carbon::parse($advertisement->enddate)->format('Y-m-d') : '' }}" readonly>
            </div>

            <div>
                <label class="label">Durasi Iklan</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ $advertisement->duration }} Hari" readonly>
            </div>

            <div>
                <label class="label">Total Budget</label>
                <input type="text" class="input bg-gray-100"
                       value="Rp {{ number_format($advertisement->total_budget) }}" readonly>
            </div>

            {{-- DESKRIPSI (SETENGAH) --}}
            <div>
                <label class="label">Deskripsi Iklan</label>
                <textarea class="input bg-gray-100" rows="3" readonly>{{ $advertisement->description }}</textarea>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="label">Status</label>
                <input type="text" class="input bg-gray-100"
                       value="{{ ucfirst($advertisement->status) }}" readonly>
            </div>

        </div>

        {{-- AKSI --}}
        <div class="mt-8 flex justify-end gap-3">
            @if($advertisement->allow_cancel)
                <button type="button" 
                        onclick="if(confirm('Apakah Anda yakin ingin membatalkan iklan ini?')) { window.location.href='{{ route('my-ads.cancel', $advertisement->id) }}'; }"
                        class="px-6 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                    Batalkan Iklan
                </button>
            @endif
            <a href="{{ route('my-ads.index') }}" 
               class="px-6 py-2 rounded-md bg-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-400">
                Kembali ke Daftar Iklan
            </a>
        </div>

    </div>

    {{-- RIGHT SIDE - TRANSACTIONS --}}
    <div class="col-span-1">
        <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Transaksi</h2>

            @php
                $transactions = $advertisement->transactions()->latest()->get();
            @endphp

            @if($transactions->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">Belum ada transaksi</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($transactions as $transaction)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-semibold text-gray-700">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($transaction->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif($transaction->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($transaction->payment_status === 'failed') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </div>
                            
                            <div class="text-xs text-gray-600 space-y-1">
                                <p><strong>Metode:</strong> {{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? 'N/A')) }}</p>
                                
                                @if($transaction->payment_date)
                                    <p><strong>Tanggal:</strong> {{ $transaction->payment_date->format('d M Y H:i') }}</p>
                                @endif
                                
                                @if($transaction->transaction_reference)
                                    <p><strong>Ref:</strong> {{ $transaction->transaction_reference }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- SUMMARY --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm text-gray-600">Total Transaksi:</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $transactions->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total Bayar:</span>
                        <span class="text-sm font-bold text-green-600">
                            Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

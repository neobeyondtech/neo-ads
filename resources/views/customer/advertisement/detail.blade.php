@extends('layout.app')

@section('title', 'Detail Iklan - NeoAds')

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-8 max-w-5xl">

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
@endsection

@extends('layout.app')

@section('title', 'Iklan - NeoAds')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-semibold text-gray-500">Iklan</h1>

        <a href="{{ route('my-ads.create') }}"
           class="px-4 py-2 rounded-md bg-blue-900 text-white text-sm font-medium hover:bg-blue-800">
            + Buat Iklan Baru
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form method="GET" action="{{ route('my-ads.index') }}" class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-900">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" @selected($status === $s)>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-900 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
                Filter
            </button>
            @if($status)
                <a href="{{ route('my-ads.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Iklan</th>
                        <th class="px-6 py-3 text-left">Target Lokasi</th>
                        <th class="px-6 py-3 text-left">Target Kendaraan</th>
                        <th class="px-6 py-3 text-left">Target Eksposure(KM)</th>
                        <th class="px-6 py-3 text-left">Tanggal Iklan Dimulai</th>
                        <th class="px-6 py-3 text-left">Tanggal Iklan Berakhir</th>
                        <th class="px-6 py-3 text-left">Total Budget</th>
                        <th class="px-6 py-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ads as $item)
                    <tr class="odd:bg-white even:bg-neutral-50 hover:bg-neutral-100 cursor-pointer transition" 
                        onclick="window.location.href='{{ route('my-ads.show', $item->id) }}'">
                        <td class="px-6 py-3">{{ $ads->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-3 font-medium">{{ $item->title }}</td>
                        <td class="px-6 py-3">{{ $item->location->name ?? 'N/A' }}</td>
                        <td class="px-6 py-3">{{ $item->target_partner ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $item->target_distance }}</td>
                        <td class="px-6 py-3">{{ $item->startdate->format('d M Y') }}</td>
                        <td class="px-6 py-3">{{ $item->enddate?->format('d M Y') ?? '-' }}</td>
                        <td class="px-6 py-3">Rp{{ number_format($item->total_budget ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 text-xs rounded font-medium 
                                @if($item->status === 'draft') bg-gray-100 text-gray-600
                                @elseif($item->status === 'on_review') bg-blue-100 text-blue-600
                                @elseif($item->status === 'searching_partner') bg-yellow-100 text-yellow-600
                                @elseif($item->status === 'active') bg-green-100 text-green-600
                                @elseif($item->status === 'completed') bg-purple-100 text-purple-600
                                @elseif($item->status === 'cancelled') bg-red-100 text-red-600
                                @else bg-gray-100 text-gray-600
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                            Belum ada iklan. <a href="{{ route('my-ads.create') }}" class="text-blue-900 font-medium">Buat iklan sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-between items-center px-6 py-4 text-sm text-gray-500">
            <span>Showing {{ $ads->firstItem() ?? 0 }} to {{ $ads->lastItem() ?? 0 }} of {{ $ads->total() }} data</span>
            <div class="flex gap-1">
                {{-- Previous Button --}}
                @if($ads->onFirstPage())
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-400 cursor-not-allowed" disabled>← Previous</button>
                @else
                    <a href="{{ $ads->previousPageUrl() }}&status={{ $status }}" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">← Previous</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($ads->getUrlRange(1, $ads->lastPage()) as $page => $url)
                    @if($page === $ads->currentPage())
                        <button class="px-3 py-1 bg-blue-900 text-white rounded font-medium">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}&status={{ $status }}" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if($ads->hasMorePages())
                    <a href="{{ $ads->nextPageUrl() }}&status={{ $status }}" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Next →</a>
                @else
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-400 cursor-not-allowed" disabled>Next →</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

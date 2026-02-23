@extends('layout.app')

@section('title', 'Monitoring - NeoAds')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-semibold text-gray-500">Monitoring</h1>

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

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500"> 
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Judul Iklan</th>
                    <th class="px-4 py-3 text-left">Total Target</th>
                    <th class="px-4 py-3 text-left">Total Achieved</th>
                    <th class="px-4 py-3 text-left">Progress</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                
                <tr class="border-t hover:bg-gray-50">

                    {{-- No --}}
                    <td class="px-4 py-3">
                       1
                    </td>

                    {{-- Judul --}}
                    <td class="px-4 py-3 font-medium text-gray-700">
                       judul 1
                    </td>

                    {{-- target --}}
                    <td class="px-4 py-3 text-gray-600">
                        {{ number_format(20000, 0, ',', '.') }}
                    </td>

                    {{-- achived --}}
                    <td class="px-4 py-3 text-gray-600">
                        {{ number_format(100000, 0, ',', '.') }}
                    </td>

                    {{-- Progress --}}
                    <td class="px-4 py-3 w-64">
                        @php
                            $progress = 80;
                        @endphp

                        <div class="flex items-center gap-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div 
                                    class="h-2.5 rounded-full
                                    @if($progress >= 100) bg-green-500
                                    @elseif($progress >= 70) bg-yellow-400
                                    @else bg-blue-500
                                    @endif"
                                    style="width: {{ min($progress,100) }}%">
                                </div>
                            </div>

                            <span class="text-xs text-gray-500">
                                {{ $progress }}%
                            </span>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded-full
                          
                        ">
                            Running
                        </span>
                    </td>

                </tr>
                
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($monitorings->count() > 0)
        <div class="flex justify-between items-center px-4 py-3 text-sm text-gray-500">
            <span>
                Showing {{ $monitorings->firstItem() ?? 0 }} 
                to {{ $monitorings->lastItem() ?? 0 }} 
                from {{ $monitorings->total() }} data
            </span>

            <div class="flex gap-1">
                {{ $monitorings->links() }}
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
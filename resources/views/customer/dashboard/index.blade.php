@extends('layout.app')

@section('title', 'Dashboard - NeoAds')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <div class="flex items-center gap-2 mt-2">
            <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span>
            <span class="text-gray-400">•</span>
            <span class="text-gray-500">{{ Auth::user()->email }}</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-gray-500 text-sm mb-2">Total Iklan</div>
            <div class="text-3xl font-bold text-blue-900">12</div>
            <div class="text-green-600 text-sm mt-2">↗︎ 2 dari bulan lalu</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-gray-500 text-sm mb-2">Tayangan (Impressions)</div>
            <div class="text-3xl font-bold text-blue-900">45.2K</div>
            <div class="text-green-600 text-sm mt-2">↗︎ 14% kenaikan</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="text-gray-500 text-sm mb-2">Klik Iklan</div>
            <div class="text-3xl font-bold text-blue-900">1,200</div>
            <div class="text-gray-600 text-sm mt-2">CTR: 2.6%</div>
        </div>
    </div>

    <!-- Aktivitas Terakhir -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terakhir</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Iklan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Promo ACE Februari</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">28 Feb 2026</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
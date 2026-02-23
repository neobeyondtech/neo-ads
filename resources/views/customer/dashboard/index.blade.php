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

<br>
<!-- Campaign Dashboard -->
<div class="space-y-8">

    <!-- Campaign Title -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-900">Promo ACE Februari</h2>
        <div class="flex gap-3">
            <button class="px-4 py-2 text-sm bg-gray-100 rounded-lg">Tanggal</button>
            <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg">Unduh Laporan</button>
        </div>
    </div>

    <!-- METRIK -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Metrik Jangkauan</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Left metrics -->
            <div class="space-y-4">

                <div class="bg-white border rounded-lg p-5">
                    <div class="text-gray-500 text-sm">Total Jarak Tempuh</div>
                    <div class="text-xs text-gray-400 mb-2">
                        Akumulasi kilometer kendaraan selama kampanye
                    </div>
                    <div class="text-2xl font-bold text-blue-900">13.059</div>
                </div>

                <div class="bg-white border rounded-lg p-5">
                    <div class="text-gray-500 text-sm">Estimasi Impresi</div>
                    <div class="text-xs text-gray-400 mb-2">
                        Berdasarkan kepadatan lalu lintas
                    </div>
                    <div class="text-2xl font-bold text-blue-900">543.790</div>
                </div>

                <div class="bg-white border rounded-lg p-5">
                    <div class="text-gray-500 text-sm">Mitra Aktif</div>
                    <div class="text-xs text-gray-400 mb-2">
                        Kendaraan yang sedang aktif
                    </div>
                    <div class="text-2xl font-bold text-blue-900">13</div>
                </div>

            </div>

            <!-- Heatmap -->
            <div class="md:col-span-2 bg-white border rounded-lg flex items-center justify-center h-[260px]">
                <span class="text-gray-400 font-medium">
                    [Heatmap / Peta Sebaran]
                </span>
            </div>

        </div>
    </div>


    <!-- PROGRESS -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Kampanye Iklan</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Progress -->
            <div class="bg-white border rounded-lg p-6 flex flex-col items-center justify-center">
                <div class="text-gray-500 text-sm mb-2">Progress Kampanye</div>

                <div class="relative w-32 h-32 flex items-center justify-center">
                    <div class="absolute text-xl font-bold">87%</div>
                    <div class="w-32 h-32 rounded-full border-8 border-blue-500 border-t-gray-200"></div>
                </div>

                <div class="text-xs text-gray-400 mt-2">
                    Target tercapai
                </div>
            </div>


            <!-- Top routes -->
            <div class="bg-white border rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-4">Rute Teratas</div>

                <div class="space-y-3 text-sm">

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Jakarta</span>
                            <span>32%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded">
                            <div class="h-2 bg-blue-600 rounded w-[32%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Bandung</span>
                            <span>12%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded">
                            <div class="h-2 bg-blue-600 rounded w-[12%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Surabaya</span>
                            <span>10%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded">
                            <div class="h-2 bg-blue-600 rounded w-[10%]"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Medan</span>
                            <span>7%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded">
                            <div class="h-2 bg-blue-600 rounded w-[7%]"></div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Placeholder -->
            <div class="bg-white border rounded-lg p-6 flex items-center justify-center">
                <span class="text-gray-400">XXX</span>
            </div>

        </div>
    </div>

</div>
@endsection
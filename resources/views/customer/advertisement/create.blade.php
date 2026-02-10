@extends('layout.app')

@section('title', 'Buat Iklan Baru - NeoAds')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="grid grid-cols-3 gap-8">
    {{-- Calculator Box (Left) --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 h-fit sticky top-8">
        <h2 class="text-lg font-bold text-blue-900 mb-6">Kalkulator Harga</h2>
        
        <div class="space-y-4">
            {{-- Tipe Stiker --}}
            <div>
                <label class="label text-sm font-semibold text-blue-900">Tipe Stiker*</label>
                <select id="calc_sticker_type" class="input text-sm @error('sticker_area_type') border-red-500 @enderror">
                    <option value="">-- Pilih Tipe Stiker --</option>
                    @foreach($stickerAreas as $option)
                        <option value="{{ $option['value'] }}" data-price="{{ $option['price'] }}">
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah Kendaraan --}}
            <div>
                <label class="label text-sm font-semibold text-blue-900">Jumlah Kendaraan</label>
                <input type="number" id="calc_vehicle_count" class="input text-sm" value="1" min="1" step="1">
            </div>

            {{-- Jarak Tempuh (KM) --}}
            <div>
                <label class="label text-sm font-semibold text-blue-900">Jarak Tempuh (KM)</label>
                <input type="number" id="calc_distance" class="input text-sm" value="100" min="1" step="0.01">
            </div>

            {{-- Budget (Optional) --}}
            <div>
                <label class="label text-sm font-semibold text-blue-900">Budget Maksimal (Opsional)</label>
                <input type="number" id="calc_budget" class="input text-sm" placeholder="Kosongkan jika tidak ada batasan" min="0" step="1000">
            </div>

            {{-- Calculate Button --}}
            <button type="button" id="calc_button" 
                    class="w-full mt-6 px-4 py-2 rounded-md bg-blue-900 text-white text-sm font-medium hover:bg-blue-800 disabled:opacity-50 disabled:cursor-not-allowed">
                Hitung Harga
            </button>

            {{-- Result Box --}}
            <div class="mt-6 p-4 bg-white border-2 border-blue-300 rounded-md" id="result_box" style="display: none;">
                <div class="text-center">
                    <p class="text-xs text-blue-600 mb-2">Estimasi Harga</p>
                    <p class="text-3xl font-bold text-blue-900" id="result_price">Rp 0</p>
                    <p class="text-xs text-blue-500 mt-2">
                        <span id="result_breakdown"></span>
                    </p>
                </div>

                {{-- Budget Adjustment Info --}}
                <div id="budget_info" style="display: none;" class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-800">
                    <p class="font-semibold mb-1">⚠️ Penyesuaian Budget:</p>
                    <p id="budget_adjustment_text"></p>
                </div>

                {{-- Copy Result --}}
                <button type="button" id="copy_result_btn" 
                        class="w-full mt-4 px-3 py-1 text-xs rounded-md bg-blue-900 text-white font-medium hover:bg-blue-800">
                    Salin Ke Form
                </button>
            </div>
        </div>
    </div>

    {{-- Form (Right) --}}
    <div class="col-span-2 bg-white rounded-lg border border-gray-200 p-8">

    <h1 class="text-2xl font-bold text-gray-400 mb-6">
        Buat Iklan Baru
    </h1>

    <form method="POST" action="{{ route('my-ads.store') }}" class="grid grid-cols-2 gap-6">
        @csrf

        {{-- Judul --}} 
        <div>
            <label class="label">Judul Iklan*</label>
            <input type="text" class="input @error('title') border-red-500 @enderror" 
                   name="title" value="{{ old('title') }}">
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tujuan Iklan (Goal Type) --}}
        <div>
            <label class="label">Tujuan Iklan*</label>
            <select class="input @error('goal_type') border-red-500 @enderror" name="goal_type">
                <option value="">-- Pilih Tujuan --</option>
                @foreach($goalTypes as $option)
                    <option value="{{ $option['value'] }}" 
                            @selected(old('goal_type') === $option['value'])>
                        {{ $option['label'] }}
                    </option>
                @endforeach
            </select>
            @error('goal_type')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Target Lokasi --}}
        <div>
            <label class="label">Target Lokasi Iklan*</label>
            <select id="target_location_id" class="input @error('target_location_id') border-red-500 @enderror" name="target_location_id">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" 
                            @selected(old('target_location_id') == $city->id)>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('target_location_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Area Sticker (Sticker Type) --}}
        <div>
            <label class="label">Lokasi Stiker Pada Kendaraan*</label>
            <select id="sticker_area_type" class="input @error('sticker_area_type') border-red-500 @enderror" name="sticker_area_type">
                <option value="">-- Pilih Lokasi Stiker --</option>
                @foreach($stickerAreas as $option)
                    <option value="{{ $option['value'] }}" 
                            @selected(old('sticker_area_type') === $option['value'])>
                        {{ $option['label'] }}
                    </option>
                @endforeach
            </select>
            @error('sticker_area_type')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Target Jarak (Distance) --}}
        <div>
            <label class="label">Target Eksposur Tercapai (KM)*</label>
            <input type="number" class="input @error('target_distance') border-red-500 @enderror" 
                   name="target_distance" value="{{ old('target_distance') }}" step="0.01" min="10">
            @error('target_distance')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Target Jarak (Distance) --}}
        <div>
            <label class="label">Target Jumlah Kendaraan*</label>
            <input type="number" class="input @error('target_partner') border-red-500 @enderror" 
                   name="target_partner" value="{{ old('target_partner') }}" step="1" min="1">
            @error('target_partner')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div>
            <label class="label">Tanggal Iklan Dimulai*</label>
            <input type="date" class="input @error('startdate') border-red-500 @enderror" 
                   name="startdate" value="{{ old('startdate') }}">
            @error('startdate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tanggal Berakhir --}}
        <div>
            <label class="label">Tanggal Iklan Berakhir</label>
            <input type="date" class="input @error('enddate') border-red-500 @enderror" 
                   name="enddate" value="{{ old('enddate') }}" id="enddate">
            @error('enddate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Durasi (Auto-calculated) --}}
        <div>
            <label class="label">Durasi Iklan (Hari)</label>
            <input type="text" id="duration" disabled
                   class="input bg-gray-100"
                   value="0">
        </div>

        {{-- Deskripsi --}}
        <div class="col-span-2">
            <label class="label">Deskripsi Iklan</label>
            <textarea class="input @error('description') border-red-500 @enderror" 
                      name="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Button --}}
        <div class="col-span-2 flex justify-end gap-3 mt-4">
            <a href="{{ route('my-ads.index') }}" 
               class="px-6 py-2 rounded-md bg-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-400">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2 rounded-md bg-blue-900 text-white text-sm font-medium hover:bg-blue-800">
                Simpan
            </button>
        </div>
    </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.querySelector('input[name="startdate"]');
        const endDateInput = document.getElementById('enddate');
        const durationInput = document.getElementById('duration');

        function calculateDuration() {
            if (startDateInput.value && endDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                durationInput.value = duration > 0 ? duration : 0;
            }
        }

        startDateInput.addEventListener('change', calculateDuration);
        endDateInput.addEventListener('change', calculateDuration);
        calculateDuration();

        // Initialize Select2
        $('#target_location_id').select2({
            placeholder: '-- Pilih Lokasi --',
            allowClear: true,
            language: {
                inputTooShort: function() {
                    return 'Mulai ketik untuk mencari...';
                },
                noResults: function() {
                    return 'Lokasi tidak ditemukan';
                }
            }
        });

        $('#sticker_area_type').select2({
            placeholder: '-- Pilih Lokasi Stiker --',
            allowClear: true,
            language: {
                inputTooShort: function() {
                    return 'Mulai ketik untuk mencari...';
                },
                noResults: function() {
                    return 'Lokasi stiker tidak ditemukan';
                }
            }
        });

        // ===== CALCULATOR LOGIC =====
        const calcStickerType = document.getElementById('calc_sticker_type');
        const calcVehicleCount = document.getElementById('calc_vehicle_count');
        const calcDistance = document.getElementById('calc_distance');
        const calcBudget = document.getElementById('calc_budget');
        const calcButton = document.getElementById('calc_button');
        const resultBox = document.getElementById('result_box');
        const resultPrice = document.getElementById('result_price');
        const resultBreakdown = document.getElementById('result_breakdown');
        const budgetInfo = document.getElementById('budget_info');
        const budgetAdjustmentText = document.getElementById('budget_adjustment_text');
        const copyResultBtn = document.getElementById('copy_result_btn');

        // Enable/disable calculate button
        function updateCalcButtonState() {
            calcButton.disabled = !calcStickerType.value;
        }

        calcStickerType.addEventListener('change', updateCalcButtonState);

        // Calculate price via backend API
        function calculatePrice() {
            if (!calcStickerType.value) {
                alert('Pilih tipe stiker terlebih dahulu');
                return;
            }

            const stickerType = calcStickerType.value;
            const vehicleCount = parseInt(calcVehicleCount.value) || 1;
            const distance = parseFloat(calcDistance.value) || 0;
            const budget = parseInt(calcBudget.value) || 0;

            // Show loading state
            calcButton.disabled = true;
            calcButton.textContent = 'Menghitung...';

            // Call backend API
            fetch('{{ route("my-ads.calculate-price") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    sticker_type: stickerType,
                    vehicle_count: vehicleCount,
                    distance: distance,
                    budget: budget || null
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const data = result.data;
                    resultPrice.textContent = data.formatted_price;
                    resultBreakdown.textContent = data.breakdown;
                    resultBox.style.display = 'block';

                    // Store values for copy function
                    resultBox.dataset.vehicles = data.vehicles;
                    resultBox.dataset.distance = data.distance;
                    resultBox.dataset.price = data.price;

                    // Show/hide budget adjustment info
                    if (data.budget_adjusted) {
                        budgetInfo.style.display = 'block';
                        budgetAdjustmentText.innerHTML = data.adjustment_message + '<br/>Harga disesuaikan: ' + data.formatted_price;
                    } else {
                        budgetInfo.style.display = 'none';
                    }
                } else {
                    alert(result.message || 'Terjadi kesalahan saat menghitung harga');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghitung harga');
            })
            .finally(() => {
                calcButton.disabled = false;
                calcButton.textContent = 'Hitung Harga';
            });
        }

        // Copy result to form
        copyResultBtn.addEventListener('click', function() {
            // Update Select2 dropdown
            $('#sticker_area_type').val(calcStickerType.value).trigger('change');
            document.querySelector('input[name="target_partner"]').value = resultBox.dataset.vehicles;
            document.querySelector('input[name="target_distance"]').value = resultBox.dataset.distance;
            document.querySelector('input[name="total_budget"]').value = resultBox.dataset.price;
            
            // Scroll to form
            document.querySelector('input[name="target_partner"]').scrollIntoView({ behavior: 'smooth' });
        });

        calcButton.addEventListener('click', calculatePrice);

        // Auto-calculate on input change
        calcVehicleCount.addEventListener('change', function() {
            if (resultBox.style.display !== 'none') {
                calculatePrice();
            }
        });
        calcDistance.addEventListener('change', function() {
            if (resultBox.style.display !== 'none') {
                calculatePrice();
            }
        });
        calcBudget.addEventListener('change', function() {
            if (resultBox.style.display !== 'none') {
                calculatePrice();
            }
        });

        updateCalcButtonState();
    });
</script>
@endsection

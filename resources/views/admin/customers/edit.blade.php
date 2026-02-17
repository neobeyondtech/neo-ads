@extends('admin.layout')

@section('title', 'Edit Customer - Admin')
@section('page-title', 'Edit Customer')

@section('content')
<style>
    .select2-selection--single {
        height: 45px !important;
    }
    .select2-selection__rendered {
        line-height: 45px !important;
    }
</style>
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Edit Customer</h2>
        <a href="{{ route('admin.customers.show', $customer) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="bg-white rounded-lg border border-gray-200 p-6 space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        {{-- Customer Type --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Customer Type</label>
            <select name="customer_type_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select Customer Type --</option>
                @foreach(\App\Models\CustomerType::all() as $customertype)
                    <option value="{{ $customertype->id }}"
                        {{ old('customer_type_id', $customer->customer_type_id) == $customertype->id ? 'selected' : '' }}>
                        {{ $customertype->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_type_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Customer Category --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Customer Category</label>
            <select name="customer_category_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select Customer Category --</option>
                @foreach(\App\Models\CustomerCategory::all() as $customercategory)
                    <option value="{{ $customercategory->id }}"
                        {{ old('customer_category_id', $customer->customer_category_id) == $customercategory->id ? 'selected' : '' }}>
                        {{ $customercategory->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
            <input type="text" name="name"
                value="{{ old('name', $customer->name) }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- NPWP --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">NPWP NUMBER</label>
            <input type="text" name="NPWP_number"
                value="{{ old('NPWP_number', $customer->NPWP_number) }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
            @error('NPWP_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Province --}}
        <div class="mb-4">
            <label for="province_id" class="block text-gray-700 font-semibold mb-2">Province</label>
            <select name="province_id" id="province_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select Province --</option>
                @if(!empty($locationData['province_id']))
                    <option value="{{ $locationData['province_id'] }}" selected>{{ $locationData['province_name'] }}</option>
                @endif
            </select>
            @error('province_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- City --}}
        <div class="mb-4">
            <label for="city_id" class="block text-gray-700 font-semibold mb-2">City</label>
            <select name="city_id" id="city_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select City --</option>
                @if(!empty($locationData['city_id']))
                    <option value="{{ $locationData['city_id'] }}" selected>{{ $locationData['city_name'] }}</option>
                @endif
            </select>
            @error('city_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- District --}}
        <div class="mb-4">
            <label for="district_id" class="block text-gray-700 font-semibold mb-2">District</label>
            <select name="district_id" id="district_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select District --</option>
                @if(!empty($locationData['district_id']))
                    <option value="{{ $locationData['district_id'] }}" selected>{{ $locationData['district_name'] }}</option>
                @endif
            </select>
            @error('district_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Subdistrict --}}
        <div class="mb-4">
            <label for="subdistrict_id" class="block text-gray-700 font-semibold mb-2">Sub District</label>
            <select name="subdistrict_id" id="subdistrict_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">-- Select Sub District --</option>
                @if(!empty($locationData['subdistrict_id']))
                    <option value="{{ $locationData['subdistrict_id'] }}" selected>{{ $locationData['subdistrict_name'] }}</option>
                @endif
            </select>
            @error('subdistrict_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Address --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <textarea name="address" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email"
                value="{{ old('email', $customer->email) }}"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone"
                value="{{ old('phone', $customer->phone) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Customer
            </button>
        </div>
    </form>
</div>

{{-- Select2 CSS dan JS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = $('#province_id');
    const citySelect = $('#city_id');
    const districtSelect = $('#district_id');
    const subdistrictSelect = $('#subdistrict_id');

    // Data lokasi dari server
    const locationData = @json($locationData);

    // Inisialisasi Province Select2
    provinceSelect.select2({
        placeholder: 'Cari Provinsi...',
        allowClear: true,
        dropdownParent: $('body'),
        ajax: {
            url: '/api/locations/provinces',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(item => ({ id: item.id, text: item.name }))
                };
            }
        },
        minimumInputLength: 0
    });

    // Set nilai province jika ada
    if (locationData.province_id) {
        provinceSelect.val(locationData.province_id).trigger('change');
    }

    // Inisialisasi City Select2
    citySelect.select2({
        placeholder: 'Cari Kota...',
        allowClear: true,
        dropdownParent: $('body'),
        ajax: {
            url: '/api/locations/cities',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    province_id: provinceSelect.val()
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({ id: item.id, text: item.name }))
                };
            }
        },
        minimumInputLength: 0
    });

    if (locationData.city_id) {
        citySelect.val(locationData.city_id).trigger('change');
    }

    // Inisialisasi District Select2
    districtSelect.select2({
        placeholder: 'Cari Kecamatan...',
        allowClear: true,
        dropdownParent: $('body'),
        ajax: {
            url: '/api/locations/districts',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    city_id: citySelect.val()
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({ id: item.id, text: item.name }))
                };
            }
        },
        minimumInputLength: 0
    });

    if (locationData.district_id) {
        districtSelect.val(locationData.district_id).trigger('change');
    }

    // Inisialisasi Subdistrict Select2
    subdistrictSelect.select2({
        placeholder: 'Cari Kelurahan...',
        allowClear: true,
        dropdownParent: $('body'),
        ajax: {
            url: '/api/locations/subdistricts',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    district_id: districtSelect.val()
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({ id: item.id, text: item.name }))
                };
            }
        },
        minimumInputLength: 0
    });

    if (locationData.subdistrict_id) {
        subdistrictSelect.val(locationData.subdistrict_id).trigger('change');
    }

    // Handle Province change
    provinceSelect.on('change', function() {
        const provinceId = $(this).val();
        citySelect.val(null).trigger('change');
        districtSelect.val(null).trigger('change');
        subdistrictSelect.val(null).trigger('change');

        if (provinceId) {
            citySelect.prop('disabled', false);
            districtSelect.prop('disabled', true);
            subdistrictSelect.prop('disabled', true);
        } else {
            citySelect.prop('disabled', true);
            districtSelect.prop('disabled', true);
            subdistrictSelect.prop('disabled', true);
        }
    });

    // Handle City change
    citySelect.on('change', function() {
        const cityId = $(this).val();
        districtSelect.val(null).trigger('change');
        subdistrictSelect.val(null).trigger('change');

        if (cityId) {
            districtSelect.prop('disabled', false);
            subdistrictSelect.prop('disabled', true);
        } else {
            districtSelect.prop('disabled', true);
            subdistrictSelect.prop('disabled', true);
        }
    });

    // Handle District change
    districtSelect.on('change', function() {
        const districtId = $(this).val();
        subdistrictSelect.val(null).trigger('change');

        if (districtId) {
            subdistrictSelect.prop('disabled', false);
        } else {
            subdistrictSelect.prop('disabled', true);
        }
    });
});
</script>
@endsection
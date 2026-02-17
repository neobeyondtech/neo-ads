@extends('admin.layout')

@section('content')
<style>
    .select2-selection--single {
        height: 45px !important; /* sesuaikan tinggi */
    }
    .select2-selection__rendered {
        line-height: 45px !important;
    }
</style>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Add Customer</h1>
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Please fix the following errors:</strong>
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.customers.store') }}" method="POST">
                @csrf

                {{-- Customer Type --}}
                <div class="mb-4">
                    <label for="customer_type_id" class="block text-gray-700 font-semibold mb-2">Customer Type</label>
                    <select name="customer_type_id" id="customer_type_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Customer Type --</option>
                        @foreach(\App\Models\CustomerType::all() as $customertype)
                            <option value="{{ $customertype->id }}">{{ $customertype->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_type_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Customer Category --}}
                <div class="mb-4">
                    <label for="customer_category_id" class="block text-gray-700 font-semibold mb-2">Customer Category</label>
                    <select name="customer_category_id" id="customer_category_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Customer Category --</option>
                        @foreach(\App\Models\CustomerCategory::all() as $customercategory)
                            <option value="{{ $customercategory->id }}">{{ $customercategory->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NPWP --}}
                <div class="mb-4">
                    <label for="NPWP_number" class="block text-gray-700 font-semibold mb-2">NPWP Number</label>
                    <input type="text" name="NPWP_number" id="NPWP_number" value="{{ old('NPWP_number') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('NPWP_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Province --}}
                <div class="mb-4">
                    <label for="province_id" class="block text-gray-700 font-semibold mb-2">Province</label>
                    <select name="province_id" id="province_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Province --</option>
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- City --}}
                <div class="mb-4">
                    <label for="city_id" class="block text-gray-700 font-semibold mb-2">City</label>
                    <select name="city_id" id="city_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled required>
                        <option value="">-- Select City --</option>
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- District --}}
                <div class="mb-4">
                    <label for="district_id" class="block text-gray-700 font-semibold mb-2">District</label>
                    <select name="district_id" id="district_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled required>
                        <option value="">-- Select District --</option>
                    </select>
                    @error('district_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subdistrict --}}
                <div class="mb-4">
                    <label for="subdistrict_id" class="block text-gray-700 font-semibold mb-2">Sub District</label>
                    <select name="subdistrict_id" id="subdistrict_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled required>
                        <option value="">-- Select Sub District --</option>
                    </select>
                    @error('subdistrict_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                    <textarea name="address" id="address" rows="3" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Add Customer
                    </button>
                    <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Info</h2>
            <p class="text-gray-600 text-sm">
                Add a new customer to the system. Email should be unique and will be used for account registration.
            </p>
        </div>
    </div>
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

    // Initialize Province Select2
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
                    results: data.map(function(item) {
                        return { id: item.id, text: item.name };
                    })
                };
            }
        },
        minimumInputLength: 0
    });

    // Load all provinces on focus
    provinceSelect.on('select2:opening', function() {
        if (provinceSelect.data('select2').$dropdown.find('.select2-results__option').length === 0) {
            provinceSelect.select2('open');
        }
    });

    // Initialize City Select2
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
                    results: data.map(function(item) {
                        return { id: item.id, text: item.name };
                    })
                };
            }
        },
        minimumInputLength: 0
    });

    // Initialize District Select2
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
                    results: data.map(function(item) {
                        return { id: item.id, text: item.name };
                    })
                };
            }
        },
        minimumInputLength: 0
    });

    // Initialize Subdistrict Select2
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
                    results: data.map(function(item) {
                        return { id: item.id, text: item.name };
                    })
                };
            }
        },
        minimumInputLength: 0
    });

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
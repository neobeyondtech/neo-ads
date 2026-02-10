
{{-- profile/index.blade.php --}}
@extends('layout.app')

@section('title', 'Profile - NeoAds')
@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-4xl font-semibold text-gray-500">Profile</h1>
    </div>

    {{-- Error and Success Messages --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="text-red-600 mt-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-red-800 mb-2">Terjadi kesalahan validasi:</h3>
                    <ul class="list-disc list-inside space-y-1 text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="text-green-600 mt-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="text-green-800">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <form action="{{ route('my-profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ================= Informasi Perusahaan ================= --}}
        <section class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-400 mb-6">
                Informasi Perusahaan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Perusahaan --}}
                <div>
                    <label class="label">Nama Perusahaan</label>
                    <input type="text" name="customer_name"
                        value="{{ old('customer_name', $customer->name ?? '') }}"
                        class="input @error('customer_name') border-red-500 @enderror">
                    @error('customer_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Perusahaan --}}
                <div>
                    <label class="label">Jenis Perusahaan</label>
                    <select name="customer_type_id" class="input @error('customer_type_id') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        @foreach($options['customer_type'] as $type)
                            <option value="{{ $type->id }}"
                                {{ old('customer_type_id', $customer->customer_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_type_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori Bisnis --}}
                <div>
                    <label class="label">Kategori Bisnis</label>
                    <select name="customer_category_id" class="input @error('customer_category_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($options['customer_category'] as $category)
                            <option value="{{ $category->id }}"
                                {{ old('customer_category_id', $customer->customer_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NPWP --}}
                <div>
                    <label class="label">NPWP</label>
                    <input type="text" name="npwp"
                        value="{{ old('npwp', $customer->NPWP_number ?? '') }}"
                        class="input @error('npwp') border-red-500 @enderror">
                    @error('npwp')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Provinsi --}}
                <div>
                    <label class="label">Provinsi</label>
                    <select id="province" name="province_id" class="input location-select @error('province_id') border-red-500 @enderror">
                        <option value="">Pilih Provinsi</option>
                    </select>
                    @error('province_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kota --}}
                <div>
                    <label class="label">Kota</label>
                    <select id="city" name="city_id" class="input location-select @error('city_id') border-red-500 @enderror" disabled>
                        <option value="">Pilih Kota</option>
                    </select>
                    @error('city_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label class="label">Kecamatan</label>
                    <select id="district" name="district_id" class="input location-select @error('district_id') border-red-500 @enderror" disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    @error('district_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subdistrict --}}
                <div>
                    <label class="label">Kelurahan</label>
                    <select id="subdistrict" name="subdistrict_id" class="input location-select @error('subdistrict_id') border-red-500 @enderror" disabled>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    @error('subdistrict_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="label">Alamat Lengkap Perusahaan</label>
                    <textarea name="address" rows="3"
                        class="input @error('address') border-red-500 @enderror">{{ old('address', $customer->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <div>
                    <input type="hidden" name="customer_id" value="{{ $customer->id ?? '' }}">
                </div>
                <button type="submit" class="btn-primary">
                    Simpan
                </button>
            </div>
        </section>

    </form>

    <form action="{{ route('my-profile.update-contact') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- ================= Penanggung Jawab ================= --}}
        <section class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-400 mb-6">
                Informasi Penanggung Jawab
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">Nama Depan</label>
                    <input type="text" name="customer_user_first_name"
                        value="{{ old('customer_user_first_name', $customer_user->first_name ?? '') }}"
                        class="input @error('customer_user_first_name') border-red-500 @enderror">
                    @error('customer_user_first_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Nama Belakang</label>
                    <input type="text" name="customer_user_last_name"
                        value="{{ old('customer_user_last_name',  $customer_user->last_name ?? '') }}"
                        class="input @error('customer_user_last_name') border-red-500 @enderror">
                    @error('customer_user_last_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Email</label>
                    <input type="email" name="customer_user_email"
                        value="{{ old('customer_user_email',  $customer_user->email ?? '') }}"
                        class="input @error('customer_user_email') border-red-500 @enderror">
                    @error('customer_user_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Nomor Telepon</label>
                    <input type="tel" name="customer_user_phone"
                        value="{{ old('customer_user_phone',  $customer_user->phone ?? '') }}"
                        class="input @error('customer_user_phone') border-red-500 @enderror">
                    @error('customer_user_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <div>
                    <input type="hidden" name="customer_user_id" value="{{ $customer_user->id ?? '' }}">
                    <input type="hidden" name="customer_id" value="{{ $customer->id ?? '' }}">
                </div>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </section>
    </form>
</div>

<script>
// Initialize Select2 for location dropdowns with API support
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = $('#province');
    const citySelect = $('#city');
    const districtSelect = $('#district');
    const subdistrictSelect = $('#subdistrict');

    // Get default values from Laravel (actual customer data)
    const defaultLocation = {
        province_id: '{{ $locationData['province_id'] ?? '' }}',
        province_name: '{{ $locationData['province_name'] ?? '' }}',
        city_id: '{{ $locationData['city_id'] ?? '' }}',
        city_name: '{{ $locationData['city_name'] ?? '' }}',
        district_id: '{{ $locationData['district_id'] ?? '' }}',
        district_name: '{{ $locationData['district_name'] ?? '' }}',
        subdistrict_id: '{{ $locationData['subdistrict_id'] ?? '' }}',
        subdistrict_name: '{{ $locationData['subdistrict_name'] ?? '' }}'
    };

    // Get old() values from form submission (for validation error restoration)
    const oldLocation = {
        province_id: '{{ old('province_id') }}',
        city_id: '{{ old('city_id') }}',
        district_id: '{{ old('district_id') }}',
        subdistrict_id: '{{ old('subdistrict_id') }}'
    };

    // Initialize Province Select2
    provinceSelect.select2({
        placeholder: 'Cari Provinsi...',
        allowClear: true,
        ajax: {
            url: '/api/locations/provinces',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
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
                        return {
                            id: item.id,
                            text: item.name
                        };
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
                        return {
                            id: item.id,
                            text: item.name
                        };
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
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            }
        },
        minimumInputLength: 0
    });

    // Set default values if they exist
    function loadDefaultValues() {
        // Determine which location to use: old() from validation error or default from customer
        const locationToUse = oldLocation.province_id ? oldLocation : defaultLocation;
        
        if (locationToUse.province_id) {
            // Fetch province name from API if using old() values
            if (oldLocation.province_id && !defaultLocation.province_id) {
                fetch(`/api/locations/provinces?filter=${locationToUse.province_id}`)
                    .then(res => res.json())
                    .then(data => {
                        const provinceName = data.find(p => p.id == locationToUse.province_id)?.name || '';
                        const newOption = new Option(provinceName, locationToUse.province_id, true, true);
                        provinceSelect.append(newOption).trigger('change');
                        loadCityForOldValue();
                    });
            } else {
                // Use default values with known names
                const newOption = new Option(locationToUse.province_name, locationToUse.province_id, true, true);
                provinceSelect.append(newOption).trigger('change');
                loadCityForOldValue();
            }
        }

        // Helper function to load city based on province
        function loadCityForOldValue() {
            setTimeout(() => {
                if (locationToUse.city_id) {
                    citySelect.prop('disabled', false);
                    
                    if (oldLocation.city_id && !defaultLocation.city_id) {
                        // Fetch city name from API
                        fetch(`/api/locations/cities?province_id=${locationToUse.province_id}&filter=${locationToUse.city_id}`)
                            .then(res => res.json())
                            .then(data => {
                                const cityName = data.find(c => c.id == locationToUse.city_id)?.name || '';
                                const newCityOption = new Option(cityName, locationToUse.city_id, true, true);
                                citySelect.append(newCityOption).trigger('change');
                                loadDistrictForOldValue();
                            });
                    } else {
                        const newCityOption = new Option(locationToUse.city_name, locationToUse.city_id, true, true);
                        citySelect.append(newCityOption).trigger('change');
                        loadDistrictForOldValue();
                    }
                }
            }, 100);
        }

        // Helper function to load district based on city
        function loadDistrictForOldValue() {
            setTimeout(() => {
                if (locationToUse.district_id) {
                    districtSelect.prop('disabled', false);
                    
                    if (oldLocation.district_id && !defaultLocation.district_id) {
                        // Fetch district name from API
                        fetch(`/api/locations/districts?city_id=${locationToUse.city_id}&filter=${locationToUse.district_id}`)
                            .then(res => res.json())
                            .then(data => {
                                const districtName = data.find(d => d.id == locationToUse.district_id)?.name || '';
                                const newDistrictOption = new Option(districtName, locationToUse.district_id, true, true);
                                districtSelect.append(newDistrictOption).trigger('change');
                                loadSubdistrictForOldValue();
                            });
                    } else {
                        const newDistrictOption = new Option(locationToUse.district_name, locationToUse.district_id, true, true);
                        districtSelect.append(newDistrictOption).trigger('change');
                        loadSubdistrictForOldValue();
                    }
                }
            }, 100);
        }

        // Helper function to load subdistrict based on district
        function loadSubdistrictForOldValue() {
            setTimeout(() => {
                if (locationToUse.subdistrict_id) {
                    subdistrictSelect.prop('disabled', false);
                    
                    if (oldLocation.subdistrict_id && !defaultLocation.subdistrict_id) {
                        // Fetch subdistrict name from API
                        fetch(`/api/locations/subdistricts?district_id=${locationToUse.district_id}&filter=${locationToUse.subdistrict_id}`)
                            .then(res => res.json())
                            .then(data => {
                                const subdistrictName = data.find(s => s.id == locationToUse.subdistrict_id)?.name || '';
                                const newSubdistrictOption = new Option(subdistrictName, locationToUse.subdistrict_id, true, true);
                                subdistrictSelect.append(newSubdistrictOption).trigger('change');
                            });
                    } else {
                        const newSubdistrictOption = new Option(locationToUse.subdistrict_name, locationToUse.subdistrict_id, true, true);
                        subdistrictSelect.append(newSubdistrictOption).trigger('change');
                    }
                }
            }, 100);
        }
    }

    // Call after all selects are initialized
    loadDefaultValues();

    // Handle Province change
    provinceSelect.on('change', function() {
        const provinceId = $(this).val();
        
        if (provinceId) {
            // Reset and enable city
            citySelect.val(null).trigger('change');
            citySelect.prop('disabled', false);
            
            // Reset district and subdistrict
            districtSelect.val(null).trigger('change');
            districtSelect.prop('disabled', true);
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', true);
        } else {
            // Disable all if province not selected
            citySelect.val(null).trigger('change');
            citySelect.prop('disabled', true);
            districtSelect.val(null).trigger('change');
            districtSelect.prop('disabled', true);
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', true);
        }
    });

    // Handle City change
    citySelect.on('change', function() {
        const cityId = $(this).val();
        
        if (cityId) {
            // Reset and enable district
            districtSelect.val(null).trigger('change');
            districtSelect.prop('disabled', false);
            
            // Reset subdistrict
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', true);
        } else {
            // Disable district and subdistrict
            districtSelect.val(null).trigger('change');
            districtSelect.prop('disabled', true);
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', true);
        }
    });

    // Handle District change
    districtSelect.on('change', function() {
        const districtId = $(this).val();
        
        if (districtId) {
            // Reset and enable subdistrict
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', false);
        } else {
            // Disable subdistrict
            subdistrictSelect.val(null).trigger('change');
            subdistrictSelect.prop('disabled', true);
        }
    });
});
</script>
@endsection

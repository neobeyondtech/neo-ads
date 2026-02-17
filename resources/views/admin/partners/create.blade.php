@extends('admin.layout')

@section('content')
<style>
    .select2-selection--single {
        height: 45px !important;
    }
    .select2-selection__rendered {
        line-height: 45px !important;
    }
</style>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Add Partner</h1>
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
            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="birth_date" class="block text-gray-700 font-semibold mb-2">Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('birth_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_ktp" class="block text-gray-700 font-semibold mb-2">No. KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" value="{{ old('no_ktp') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('no_ktp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="province" class="block text-gray-700 font-semibold mb-2">Province</label>
                        <select name="province" id="province" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="">-- Select Province --</option>
                        </select>
                        @error('province') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="city" class="block text-gray-700 font-semibold mb-2">City</label>
                        <select name="city" id="city" class="w-full border border-gray-300 rounded px-3 py-2" disabled required>
                            <option value="">-- Select City --</option>
                        </select>
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="district" class="block text-gray-700 font-semibold mb-2">District</label>
                        <select name="district" id="district" class="w-full border border-gray-300 rounded px-3 py-2" disabled required>
                            <option value="">-- Select District --</option>
                        </select>
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subdistrict" class="block text-gray-700 font-semibold mb-2">Sub District</label>
                        <select name="subdistrict" id="subdistrict" class="w-full border border-gray-300 rounded px-3 py-2" disabled required>
                            <option value="">-- Select Sub District --</option>
                        </select>
                        @error('subdistrict')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Full Address</label>
                    <textarea name="address" id="address" rows="3" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="img_ktp" class="block text-gray-700 font-semibold mb-2">KTP Image</label>
                        <input type="file" name="img_ktp" id="img_ktp" accept="image/*"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Maksimal 2MB. Format: JPG, PNG, JPEG</p>
                        @error('img_ktp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="img_sim" class="block text-gray-700 font-semibold mb-2">SIM Image</label>
                        <input type="file" name="img_sim" id="img_sim" accept="image/*"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Maksimal 2MB. Format: JPG, PNG, JPEG</p>
                        @error('img_sim')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(\App\Enums\PartnerStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                                {{ ucfirst($status->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Add Partner
                    </button>
                    <a href="{{ route('admin.partners.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
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
                Add a new partner to the system. Fields marked with * are required.
                Partners can be assigned vehicles and participate in campaigns.
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
    const provinceSelect = $('#province');
    const citySelect = $('#city');
    const districtSelect = $('#district');
    const subdistrictSelect = $('#subdistrict');

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
@extends('admin.layout')

@section('title', 'Edit Partner - Admin')
@section('page-title', 'Edit Partner')

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
    <h1 class="text-2xl font-bold">Edit Partner: {{ $partner->first_name }} {{ $partner->last_name }}</h1>
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
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $partner->first_name) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $partner->last_name) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="birth_date" class="block text-gray-700 font-semibold mb-2">Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $partner->birth_date ? $partner->birth_date->format('Y-m-d') : '') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('birth_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $partner->email) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $partner->phone) }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_ktp" class="block text-gray-700 font-semibold mb-2">No. KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" value="{{ old('no_ktp', $partner->no_ktp) }}" 
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
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $partner->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload KTP --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">KTP Image</label>
                    <div class="flex items-center space-x-4">
                        @if($partner->img_ktp)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $partner->img_ktp) }}" alt="KTP" class="h-24 w-auto rounded border">
                                <p class="text-xs text-gray-500 mt-1">Current KTP</p>
                            </div>
                        @endif
                        <div class="flex-grow">
                            <input type="file" name="img_ktp" id="img_ktp" accept="image/*"
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah. Maksimal 2MB. Format: JPG, PNG, JPEG</p>
                            @error('img_ktp')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Upload SIM --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">SIM Image</label>
                    <div class="flex items-center space-x-4">
                        @if($partner->img_sim)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $partner->img_sim) }}" alt="SIM" class="h-24 w-auto rounded border">
                                <p class="text-xs text-gray-500 mt-1">Current SIM</p>
                            </div>
                        @endif
                        <div class="flex-grow">
                            <input type="file" name="img_sim" id="img_sim" accept="image/*"
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah. Maksimal 2MB. Format: JPG, PNG, JPEG</p>
                            @error('img_sim')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @php
                            $statuses = ['active', 'pending', 'inactive'];
                        @endphp
                        @foreach($statuses as $statusValue)
                            <option value="{{ $statusValue }}" {{ old('status', $partner->status) == $statusValue ? 'selected' : '' }}>
                                {{ ucfirst($statusValue) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Update Partner
                    </button>
                    <a href="{{ route('admin.partners.show', $partner->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Partner Info</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">ID</p>
                    <p class="font-semibold">{{ $partner->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Vehicles Count</p>
                    <p class="font-semibold">{{ $partner->vehicles_count ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Created At</p>
                    <p class="font-semibold">{{ $partner->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Updated At</p>
                    <p class="font-semibold">{{ $partner->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
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

    // Data lokasi dari server
    const locationData = @json($locationData ?? null);

    // ================= PROVINCE =================
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

    if (locationData && locationData.province_id) {
        var newOption = new Option(locationData.province_name, locationData.province_id, true, true);
        provinceSelect.append(newOption).trigger('change');
    }

    // ================= CITY =================
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

    if (locationData && locationData.city_id) {
        var newOption = new Option(locationData.city_name, locationData.city_id, true, true);
        citySelect.append(newOption).trigger('change');
    }

    // ================= DISTRICT =================
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

    if (locationData && locationData.district_id) {
        var newOption = new Option(locationData.district_name, locationData.district_id, true, true);
        districtSelect.append(newOption).trigger('change');
    }

    // ================= SUBDISTRICT =================
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

    if (locationData && locationData.subdistrict_id) {
        var newOption = new Option(locationData.subdistrict_name, locationData.subdistrict_id, true, true);
        subdistrictSelect.append(newOption).trigger('change');
    }

    // ================= EVENT HANDLERS =================
    provinceSelect.on('change', function() {
        const provinceId = $(this).val();
        citySelect.val(null).trigger('change');
        districtSelect.val(null).trigger('change');
        subdistrictSelect.val(null).trigger('change');

        citySelect.prop('disabled', !provinceId);
        districtSelect.prop('disabled', true);
        subdistrictSelect.prop('disabled', true);
    });

    citySelect.on('change', function() {
        const cityId = $(this).val();
        districtSelect.val(null).trigger('change');
        subdistrictSelect.val(null).trigger('change');

        districtSelect.prop('disabled', !cityId);
        subdistrictSelect.prop('disabled', true);
    });

    districtSelect.on('change', function() {
        const districtId = $(this).val();
        subdistrictSelect.val(null).trigger('change');
        subdistrictSelect.prop('disabled', !districtId);
    });
});
</script>
@endsection
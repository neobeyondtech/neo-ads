@extends('admin.layout')

@section('title', 'Edit Customer - Admin')
@section('page-title', 'Edit Customer')

@section('content')
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


         <div class="mb-4">
                    <label for="province_id" class="block text-gray-700 font-semibold mb-2">Province</label>
                    <select name="province_id" id="province_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Province --</option>
                        @foreach(\App\Models\MasterProvince::all() as $p)
                            <option value="{{ $p->id }}"
                                {{ old('province_id', $customer->province_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach 
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="district_id" class="block text-gray-700 font-semibold mb-2">District</label>
                    <select name="district_id" id="district_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select District --</option>
                        @foreach(\App\Models\MasterDistrict::all() as $district)
                             <option value="{{ $district->id }}"
                                {{ old('district_id', $customer->district_id) == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="master_location_id" class="block text-gray-700 font-semibold mb-2">Sub District</label>
                    <select name="master_location_id" id="master_location_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select Sub District --</option>
                    @foreach(\App\Models\MasterSubDistrict::limit(40000)->get() as $p)     
                         <option value="{{ $p->id }}"
                            {{ old('master_location_id', $customer->master_location_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                    </select>
                    @error('master_location_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="city_id" class="block text-gray-700 font-semibold mb-2">City</label>
                    <select name="city_id" id="city_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select City --</option>
                        @foreach(\App\Models\Mastercity::all() as $p)
                            <option value="{{ $p->id }}"
                                {{ old('city_id', $customer->city_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
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


        {{-- Address --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <textarea name="address" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2">{{ old('address', $customer->address) }}</textarea>
            @error('address')
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
@endsection

@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Create Customer</h1>
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

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="NPWP_number" class="block text-gray-700 font-semibold mb-2">NPWP Number</label>
                    <input type="text" name="NPWP_number" id="NPWP_number" value="{{ old('NPWP_number') }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('NPWP_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="province_id" class="block text-gray-700 font-semibold mb-2">Province</label>
                    <select name="province_id" id="province_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select Province --</option>
                        @foreach(\App\Models\MasterProvince::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                                <div class="mb-4">
                    <label for="city_id" class="block text-gray-700 font-semibold mb-2">City</label>
                    <select name="city_id" id="city_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select City --</option>
                        @foreach(\App\Models\Mastercity::all() as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="district_id" class="block text-gray-700 font-semibold mb-2">District</label>
                    <select name="district_id" id="district_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Select District --</option>
                        @foreach(\App\Models\MasterDistrict::all() as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
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
                        @foreach(\App\Models\MasterSubdistrict::limit(40000)->get() as $subdistict)
                            <option value="{{ $subdistict->id }}">{{ $subdistict->name }}</option>
                        @endforeach
                    </select>
                    @error('master_location_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                        Create Customer
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
@endsection

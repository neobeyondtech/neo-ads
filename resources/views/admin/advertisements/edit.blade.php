@extends('admin.layout')

@section('title', 'Edit Advertisement - Admin')
@section('page-title', 'Edit Advertisement')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Edit Advertisement</h2>
        <a href="{{ route('admin.advertisements.show', $advertisement) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
    </div>
 
    <form method="POST" action="{{ route('admin.advertisements.update', $advertisement) }}" class="bg-white rounded-lg border border-gray-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Customer</label>
            <select name="customer_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select Customer --</option>
                @foreach(\App\Models\Customer::all() as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $advertisement->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">City</label>
            <select name="city_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Select City --</option>
                @foreach(\App\Models\MasterCity::all() as $city)
                    <option value="{{ $city->id }}"
                        {{ old('city_id', $advertisement->city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title"
                value="{{ old('title', $advertisement->title) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Goals</label>
            <input type="text" name="goal_type"
                value="{{ old('goal_type', $advertisement->goal_type) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('goal_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Target Lokasi</label>
            <input type="text" name="target_location"
                value="{{ old('target_location', $advertisement->target_location) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('target_location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Target KM</label>
            <input type="number" name="target_distance"
                value="{{ old('target_distance', $advertisement->target_distance) }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('target_distance')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $advertisement->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Start Date</label>
                <input type="date" name="startdate"
                    value="{{ old('startdate', $advertisement->startdate) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @error('startdate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">End Date</label>
                <input type="date" name="enddate"
                    value="{{ old('enddate', $advertisement->enddate) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @error('enddate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Budget</label>
                <input type="number" name="total_budget"
                    value="{{ old('total_budget', $advertisement->total_budget) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @error('total_budget')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    <option value="draft" {{ old('status', $advertisement->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $advertisement->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ old('status', $advertisement->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $advertisement->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Advertisement
            </button>
        </div>
    </form>
</div>
@endsection

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

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" value="{{ $advertisement->title }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Select Status</option>
                    <option value="draft" {{ $advertisement->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ $advertisement->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ $advertisement->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $advertisement->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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

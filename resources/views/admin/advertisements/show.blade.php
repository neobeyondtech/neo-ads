@extends('admin.layout')

@section('title', 'Advertisement Details - Admin')
@section('page-title', 'Advertisement Details')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">{{ $advertisement->title }}</h2>
        <div class="flex gap-2">
            @if(Auth::user()->role->canPerform('edit', 'advertisements'))
                <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Edit</a>
            @endif
            <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        {{-- Details Card --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-600">Customer</p>
                <p class="font-medium">{{ $advertisement->customer->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <p class="font-medium">{{ ucfirst($advertisement->status) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Goal Type</p>
                <p class="font-medium">{{ $advertisement->goal_type_label }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Budget</p>
                <p class="font-medium text-lg text-green-600">Rp{{ number_format($advertisement->total_budget, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Timeline Card --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-600">Start Date</p>
                <p class="font-medium">{{ $advertisement->startdate?->format('M d, Y') ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">End Date</p>
                <p class="font-medium">{{ $advertisement->enddate?->format('M d, Y') ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Duration</p>
                <p class="font-medium">{{ $advertisement->duration ?? 'N/A' }} days</p>
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Description</h3>
        <p class="text-gray-600">{{ $advertisement->description ?? 'No description' }}</p>
    </div>
</div>
@endsection

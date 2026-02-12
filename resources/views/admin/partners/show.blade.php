@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Partner Details</h1>
    @if(auth()->user()->role->canPerform('edit', 'partners'))
        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            Edit
        </a>
    @endif
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Partner Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Partner ID</p>
                    <p class="font-semibold">{{ $partner->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Name</p>
                    <p class="font-semibold">{{ $partner->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="font-semibold">{{ $partner->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Phone</p>
                    <p class="font-semibold">{{ $partner->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Address</p>
                    <p class="font-semibold">{{ $partner->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Vehicles Count</p>
                    <p class="font-semibold">{{ $partner->vehicles_count ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Created At</p>
                    <p class="font-semibold">{{ $partner->created_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Description</h2>
            <p class="text-gray-700">{{ $partner->description ?? 'No description provided' }}</p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Status</h2>
            <div class="mb-4">
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    @if($partner->status === App\Enums\PartnerStatus::ACTIVE->value)
                        bg-green-100 text-green-800
                    @elseif($partner->status === App\Enums\PartnerStatus::PENDING->value)
                        bg-yellow-100 text-yellow-800
                    @elseif($partner->status === App\Enums\PartnerStatus::INACTIVE->value)
                        bg-red-100 text-red-800
                    @else
                        bg-blue-100 text-blue-800
                    @endif">
                    {{ ucfirst($partner->status ?? 'unknown') }}
                </span>
            </div>

            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Updated At</p>
                    <p class="font-semibold">{{ $partner->updated_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                </div>
                <div class="border-t pt-3 mt-3">
                    <p class="text-gray-600 text-sm mb-2">Actions</p>
                    <div class="space-y-2">
                        @if(auth()->user()->role->canPerform('edit', 'partners'))
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">
                                Edit Partner
                            </a>
                        @endif
                        @if(auth()->user()->role->canPerform('delete', 'partners'))
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm">
                                    Delete Partner
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.partners.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Master Banks</h1>
    @if(auth()->user()->role->canPerform('create', 'masterdata'))
        <a href="{{ route('admin.banks.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
            + Add Bank
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Code</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created At</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($banks as $bank)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">{{ $bank->id }}</td>
                    <td class="px-6 py-3 text-sm">{{ $bank->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $bank->code ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $bank->created_at?->format('d M Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.banks.edit', $bank->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        @if(auth()->user()->role->canPerform('delete', 'masterdata'))
                            <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        No banks found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($banks->hasPages())
    <div class="mt-6">
        {{ $banks->links() }}
    </div>
@endif
@endsection

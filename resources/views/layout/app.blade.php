<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NeoAds')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Select2 styling to match Tailwind input styles */
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #3b82f6;
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1f2937;
            line-height: 40px;
            padding: 0 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 8px 12px;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent;
            border-width: 5px 4px 0 4px;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f0f9ff;
            color: #1e40af;
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px;
        }

        .select2-container--default .select2-results__option:hover {
            background-color: #f3f4f6;
        }

        /* Disabled state */
        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #f3f4f6;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>

    
</head>

<body class="bg-gray-100">
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white min-h-screen flex flex-col">

        {{-- Logo --}}
       <div class="h-16 flex items-center gap-3 px-6 font-bold text-xl text-blue-900">
            <img src="{{ asset('images/logo.png') }}"
                alt="NeoAds Logo"
                class="h-8 w-auto">

            <span>NeoAds</span>
        </div>

        {{-- User Info + Logout --}}
        <div class="px-6 py-4 flex items-center gap-3">
            <div class="relative inline-block">
                <!-- FOTO PROFIL -->
                <div class="relative">
                    <img
                        src="{{ asset(Auth::user()->photo ?? 'images/profile.png') }}"
                        class="w-10 h-10 rounded-full cursor-pointer object-cover"
                        onclick="toggleDropdown()"
                        alt="Profile"
                    >

                </div>
                <form
                    id="photoForm"
                    method="POST"
                    action="{{ route('profile.update-photo') }}"
                    enctype="multipart/form-data"
                    class="hidden"
                > 
                    @csrf
                    <input
                        type="file"
                        name="photo"
                        id="photoInput"
                        accept="image/png,image/jpeg"
                        onchange="this.form.submit()"
                    >
                </form>

                <!-- DROPDOWN -->
                <div
                    id="profileDropdown"
                    class="hidden absolute left-full top-0 ml-3 w-40 bg-white border rounded shadow-lg z-50"
                >   
                    <button
                        type="button"
                        onclick="openPhotoPicker()"
                        class="flex items-center w-full text-left px-4 py-2 hover:bg-gray-100 text-blue-900"
                    >
                        <i class="fa-solid fa-image mr-3"></i>
                        Ganti Foto
                    </button>
                    <button
                        type="button"
                        onclick="openPasswordForm()"
                        class="flex items-center w-full text-left px-4 py-2 hover:bg-gray-100 text-blue-900"
                    >
                        <i class="fa-solid fa-key mr-3"></i>
                        Ganti Password
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 hover:bg-gray-100" style="color: #0b1a3d;">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                    </form>
                </div>
            </div>

            <div class="text-sm leading-tight">
                <div class="font-semibold text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>

        {{-- Menu --}}
        @include('navigation.index')
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

<!-- Password Change Modal -->
<div id="passwordModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Ganti Password</h2>
            <button 
                type="button" 
                onclick="closePasswordForm()" 
                class="text-gray-400 hover:text-gray-500"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="{{ route('profile.update-password') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Password Lama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <input 
                    type="password" 
                    name="current_password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                    placeholder="Masukkan password saat ini"
                    required
                >
                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="Masukkan password baru"
                    required
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Konfirmasi password baru"
                    required
                >
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-red-800 text-sm font-semibold">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 text-sm mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Modal Footer -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button
                    type="button"
                    onclick="closePasswordForm()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium"
                >
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
function toggleDropdown() {
    event.stopPropagation();
    document.getElementById('profileDropdown').classList.toggle('hidden');
}

document.addEventListener('click', function () {
    document.getElementById('profileDropdown').classList.add('hidden');
});

function openPhotoPicker() {
    event.stopPropagation();
    document.getElementById('photoInput').click();
}

function openPasswordForm() {
    event.stopPropagation();
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('profileDropdown').classList.add('hidden');
}

function closePasswordForm() {
    document.getElementById('passwordModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('passwordModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closePasswordForm();
    }
});
</script>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Success Popup Script -->
@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            // Already on index page, no need to redirect
            // Or you can redirect to another page:
            // window.location.href = '{{ route('my-ads.index') }}';
        }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33',
    });
</script>
@endif
<!-- WhatsApp Floating Button -->
    <x-whatsapp-float />
</body>
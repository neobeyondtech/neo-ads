<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NeoAds</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .bg-custom-blue {
            background-color: #1a2e6b;
        }
        .text-custom-blue {
            color: #1a2e6b;
        }
        .border-custom-blue {
            border-color: #1a2e6b;
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Background Image -->
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center" 
             style="background-image: url('{{ asset('images/bg-image.jpg') }}')">
        </div>

        <!-- Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="max-w-md w-full mt-8">
                <!-- Logo -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="NeoAds" class="mx-auto w-32 mb-1">
                </div>
            </div>
            <h2 class="text-4xl font-bold text-[#1a2d6d]">NeoAds</h2>
        </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf 
                    
                    @if($errors->any())
                        <div class="alert alert-error shadow-lg">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Email Field -->
                    <div class="form-control">
                        <label class="label">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-custom-blue shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-custom-blue text-lg">Email</span>
                            </div>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               placeholder="examplemail@mail.com" 
                               class="input input-bordered w-full rounded-xl border-gray-300 focus:border-custom-blue focus:outline-none h-12 text-base px-4" 
                               required />
                    </div>

                    <!-- Password Field -->
                    <div class="form-control">
                        <label class="label">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-custom-blue shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-custom-blue text-lg">Kata Sandi</span>
                            </div>
                        </label>
                        <input type="password" name="password" 
                               placeholder="Masukkan kata sandi Anda" 
                               class="input input-bordered w-full rounded-xl border-gray-300 focus:border-custom-blue focus:outline-none h-12 text-base px-4" 
                               required />
                    </div>

                    <!-- Ingat Saya & Lupa Password -->
                    <div class="flex justify-between items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm" />
                            <span class="text-sm text-gray-700">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-custom-blue hover:text-blue-800 font-medium">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="flex justify-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="btn w-full bg-custom-blue hover:bg-blue-900 border-none text-white rounded-xl py-3 h-auto font-bold text-base">
                        Masuk
                    </button>

                    <!-- Google Login -->
                    <a href="{{ url('/auth/google') }}"
                       class="btn btn-outline w-full flex items-center justify-center gap-3 rounded-xl py-3 h-auto border-2 border-custom-blue text-custom-blue font-bold hover:bg-custom-blue hover:text-white hover:border-custom-blue transition-all">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5">
                        <span>Lanjutkan dengan Google</span>
                    </a>

                    <!-- Register Link -->
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="/register" class="text-custom-blue font-bold hover:text-blue-800 ml-1">
                                Daftar disini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tambahkan style untuk reCAPTCHA jika diperlukan
        document.addEventListener('DOMContentLoaded', function() {
            const recaptcha = document.querySelector('.g-recaptcha');
            if (recaptcha) {
                recaptcha.style.margin = '0 auto';
            }
        });
    </script>
</body>
</html>
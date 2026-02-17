<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - NeoAds</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
         /* Privacy Policy Modal */
            .privacy-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                overflow: auto;
            }

            .privacy-modal-content {
                background-color: white;
                margin: 5% auto;
                padding: 30px;
                border-radius: 8px;
                width: 90%;
                max-width: 700px;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            }

            .privacy-modal-close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
                line-height: 20px;
            }

            .privacy-modal-close:hover {
                color: #000;
            }

            .privacy-modal h2 {
                color: #187bcd;
                margin-bottom: 20px;
                margin-top: 0;
            }

            .privacy-modal h3 {
                color: #333;
                margin-top: 20px;
                margin-bottom: 10px;
                font-size: 1.1rem;
                font-weight: bold;
            }

                .privacy-modal h4 {
                color: #333;
                margin-top: 20px;
                margin-bottom: 10px;
                font-size: 1.0rem;
                font-weight: bold;
            }

        .privacy-modal p, .privacy-modal ul {
            line-height: 1.6;
            color: #555;
            font-size: 0.9rem;
            text-align: justify;
        }

        .privacy-modal ul {
            list-style-type: none; 
            padding-left: 25px;
            margin-bottom: 15px;
            counter-reset: item-alpha; 
        }

        .privacy-modal > ul > li, 
        .privacy-modal ul > li { 
            counter-increment: item-alpha; 
            margin-bottom: 5px;
            list-style-type: none; 
        }

        .privacy-modal ul > li::before { 
            content: counter(item-alpha, lower-alpha) ". "; 
            font-weight: normal; 
            margin-right: 5px;
        }

        .privacy-modal ul > li > ol > li::before {
            content: none; 
        }

        .privacy-modal ol {
            padding-left: 25px;
            margin-top: 5px;
            margin-bottom: 5px;
            list-style-type: decimal; 
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-24 mt-8">
                    <h2 class="text-2xl font-bold text-[#1a2d6d]">NeoAds</h2>
                </div>
                
<form action="{{ route('register.post') }}" method="POST">
    @csrf 
<div class="form-control mb-2 text-left">
    <label class="label">
        <div style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 0.6rem;">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1a2e6b] shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <span class="font-bold text-[#1a2e6b] text-xl">Nama Lengkap</span>
        </div>
    </label>
    <input type="text" name="name" placeholder="Nama Lengkap Anda" required 
        class="input input-bordered w-full rounded-2xl border-slate-400 focus:border-[#1a2e6b] focus:outline-none h-14 text-lg px-6" />
</div>

<div class="form-control mb-2 text-left">
    <label class="label">
        <div style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 0.6rem;">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1a2e6b] shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="font-bold text-[#1a2e6b] text-xl">Email</span>
        </div>
    </label>
    <input type="email" name="email" placeholder="example@mail.com" required 
        class="input input-bordered w-full rounded-2xl border-slate-400 focus:border-[#1a2e6b] focus:outline-none h-14 text-lg px-6" />
</div>

<div class="form-control mb-4 text-left">
    <label class="label">
        <div style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 0.6rem;">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1a2e6b] shrink-0">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <span class="font-bold text-[#1a2e6b] text-xl">Kata Sandi</span>
        </div>
    </label>
    <input type="password" name="password" placeholder="xxxxx" required 
        class="input input-bordered w-full rounded-2xl border-slate-400 focus:border-[#1a2e6b] focus:outline-none h-14 text-lg px-6" />
</div>
<div class="form-control mb-4 text-left">
    <label class="label">
        <div style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 0.6rem;">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1a2e6b] shrink-0">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <span class="font-bold text-[#1a2e6b] text-xl">Konfirmasi Kata Sandi</span>
        </div>
    </label>
    <input type="password" name="password_confirmation" placeholder="xxxxx" required 
        class="input input-bordered w-full rounded-2xl border-slate-400 focus:border-[#1a2e6b] focus:outline-none h-14 text-lg px-6" />
</div>

                        <div class="form-control mb-4 text-left">
                        <label class="cursor-pointer flex items-start gap-2">
                            <input type="checkbox" name="agree" class="checkbox checkbox-sm" required>
                            <span class="text-sm">
                                Saya setuju dengan 
                                <a href="#" onclick="showPrivacyPolicy(event)" class="text-blue-900 underline">Kebijakan Privasi Data</a>
                                dan
                                <a class="text-sm">dan memberikan persetujuan untuk pemrosesan data pribadi saya.</a>
                            </span>
                        </label>
                    </div>
    
    <button type="submit" class="btn w-full bg-[#1a2e6b] hover:bg-blue-950 border-none mb-4 text-white rounded-full py-3 h-auto font-bold">Daftar</button>

    <a href="{{ url('/auth/google') }}"
    class="btn btn-outline w-full flex items-center justify-center gap-2 rounded-full py-3 h-auto border-2 border-[#1a2e6b] text-[#1a2e6b] font-bold hover:bg-[#1a2e6b] hover:text-white transition-all duration-300">
    <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5">
    Lanjutkan dengan Google
</a>
    <p class="mt-4 text-sm">
    Sudah punya akun? <a href="/login" class="text-blue-900 font-bold">Masuk disini</a>
    </p>
    
</form>
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center" 
            style="background-image: url('{{ asset('images/bg-image.jpg') }}')">
        </div>
    </div>

   <div id="privacyModal" class="privacy-modal">
    <div class="privacy-modal-content">
        <span class="privacy-modal-close" onclick="closePrivacyPolicy()">&times;</span>

        <h2 style="text-align: center;">
            <strong>KEBIJAKAN PRIVASI & KESEPAKATAN LAYANAN (SLA)</strong>
        </h2>

        <p style="text-align: justify;">
            Kebijakan ini mengatur bagaimana <strong>Neo Beyond Tech ("Kami")</strong> 
            mengelola informasi bisnis dan menyediakan standar layanan kepada 
            <strong>Brand atau Penggiat Bisnis ("Advertiser")</strong> 
            yang menggunakan platform <strong>NeoAds</strong>.
        </p>

        <hr>

        <h3>1. PENGUMPULAN INFORMASI BISNIS</h3>
        <p>Kami mengumpulkan data yang diperlukan untuk identifikasi bisnis dan pelaksanaan kampanye, meliputi:</p>
        <ul>
            <li><strong>Profil Bisnis:</strong> Nama perusahaan/merek, alamat kantor, NPWP (untuk keperluan perpajakan), dan profil usaha.</li>
            <li><strong>Kontak Representatif:</strong> Nama penanggung jawab, alamat email, dan nomor telepon.</li>
            <li><strong>Materi Iklan:</strong> Desain visual, pesan iklan, dan identitas visual merek.</li>
        </ul>

        <hr>

        <h3>2. STANDAR LAYANAN (SERVICE LEVEL AGREEMENT - SLA)</h3>
        <ul>
            <li><strong>Ketersediaan Platform:</strong> Menjamin operasional aplikasi NeoAds dapat diakses secara daring (online), di luar waktu pemeliharaan (maintenance) yang diinformasikan sebelumnya.</li>
            <li><strong>Laporan Kampanye:</strong> Menyediakan laporan jangkauan iklan berdasarkan data GPS Partner yang telah divalidasi.</li>
            <li><strong>Verifikasi Partner:</strong> Memastikan kendaraan Partner telah melalui proses verifikasi kelayakan fisik dan administrasi sebelum kampanye dimulai.</li>
        </ul>

        <hr>

        <h3>3. KERAHASIAAN DATA DAN INFORMASI</h3>
        <ul>
            <li><strong>Kerahasiaan Strategi:</strong> Strategi pemasaran, materi iklan yang belum dirilis, dan data internal Advertiser tidak akan diungkapkan tanpa persetujuan tertulis.</li>
            <li><strong>Data Partner:</strong> Advertiser dilarang menghubungi Partner secara langsung di luar platform NeoAds atau menggunakan data pribadi Partner untuk tujuan lain.</li>
        </ul>

        <hr>

        <h3>4. TANGGUNG JAWAB KONTEN IKLAN</h3>
        <ul>
            <li>Advertiser bertanggung jawab penuh atas keaslian, legalitas, dan hak kekayaan intelektual (HAKI) dari konten iklan.</li>
            <li>Konten tidak boleh mengandung unsur SARA, pornografi, perjudian, politik, atau pelanggaran hukum di Indonesia.</li>
            <li>NeoAds berhak menolak atau menghentikan kampanye yang melanggar ketentuan.</li>
        </ul>

        <hr>

        <h3>5. SISTEM PEMBAYARAN DAN PENGEMBALIAN DANA (REFUND)</h3>
        <ul>
            <li>Seluruh transaksi dilakukan melalui sistem pembayaran resmi (Payment Gateway) NeoAds.</li>
            <li>Kompensasi atau refund berlaku jika target jangkauan tidak tercapai sesuai kesepakatan.</li>
        </ul>

        <hr>

        <h3>6. BATASAN TANGGUNG JAWAB</h3>
        <p style="text-align: justify;">
            Neo Beyond Tech tidak bertanggung jawab atas kerusakan fisik kendaraan Partner atau 
            insiden lalu lintas selama kampanye berjalan, kecuali ditentukan lain dalam perjanjian khusus.
        </p>
        <br>
        <hr>

        <h3>7. KONTAK DUKUNGAN BISNIS</h3>
<p>
    Call Center / WhatsApp: 
    <a style="color: #187bcd; text-decoration: none; font-weight: bold;">
        0878 1907 3201
    </a><br>
    
    Email: 
    <a style="color: #187bcd; text-decoration: none; font-weight: bold;">
        contact@neobeyondtech.com
    </a>
</p>

        <p style="margin-top: 20px; font-size: 0.85rem; color: #666;">
            <em>Terakhir diperbarui: {{ date('d F Y') }}</em>
        </p>

    </div>
</div>

</body>
</html>

<script>
    function showPrivacyPolicy(event) {
    event.preventDefault();
    document.getElementById('privacyModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closePrivacyPolicy() {
    document.getElementById('privacyModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('privacyModal');
    if (event.target == modal) {
        closePrivacyPolicy();
    }
}
</script>
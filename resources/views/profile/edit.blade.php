<x-app-layout>
    <!-- Memuat CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style> 
        body, html { background-color: #F8FAFC !important; overflow-x: hidden; scroll-behavior: smooth; } 
        .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); }
    </style>

    <!-- Notifikasi Melayang (Fades out otomatis) -->
    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition.opacity.duration.500ms class="fixed top-24 right-4 sm:right-8 bg-white border-l-4 border-emerald-500 text-slate-800 px-6 py-4 shadow-[0_10px_40px_rgba(0,0,0,0.1)] font-bold flex items-center gap-3 z-[100] rounded-r-lg">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            Berhasil Diperbarui!
        </div>
    @endif

    <!-- HEADER PROFIL (Elegan & Megah) -->
    <div class="relative bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] pt-24 sm:pt-32 pb-32 overflow-hidden clip-diagonal">
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-blue-500 opacity-20 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[30%] h-[30%] bg-white opacity-10 blur-[80px] rounded-full"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <span data-aos="fade-down" class="inline-block px-4 py-1.5 rounded-full border border-blue-400/30 text-blue-200 text-[10px] font-black uppercase tracking-[0.3em] mb-3 backdrop-blur-md">
                    Pengaturan Akun
                </span>
                <h1 data-aos="fade-right" data-aos-delay="100" class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight mb-2 drop-shadow-lg uppercase">
                    Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">Saya</span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="200" class="text-xs sm:text-sm md:text-base text-blue-200 font-medium tracking-wide max-w-xl">
                    Kelola informasi pribadi, keamanan kata sandi, dan previlese akun Anda pada sistem SPPG.
                </p>
            </div>
            
            <!-- Tombol Kembali -->
            <div data-aos="fade-left" data-aos-delay="300" class="hidden md:block">
                <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all hover:-translate-y-1 backdrop-blur-sm shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT PROFIL -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-16 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- ========================================== -->
            <!-- KOLOM KIRI: FORM UPDATE (Informasi & Password) -->
            <!-- ========================================== -->
            <div class="lg:col-span-2 flex flex-col gap-6 sm:gap-8">
                
                <!-- 1. INFORMASI PROFIL -->
                <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-10 -mt-10 z-0"></div>
                    <div class="relative z-10 p-6 sm:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-50 text-[#2563eb] rounded-xl flex items-center justify-center shrink-0 border border-blue-100 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h2 class="font-black text-xl text-slate-800 tracking-tight">Informasi Pribadi</h2>
                                <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Perbarui nama dan alamat email akun Anda</p>
                            </div>
                        </div>

                        <!-- Form Update Email & Nama yang mengarah ke route bawaan Breeze -->
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>
                        
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf @method('patch')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] focus:bg-white transition-all shadow-sm outline-none py-3.5 px-4">
                                    <x-input-error class="mt-2 text-xs text-red-500 font-bold" :messages="$errors->get('name')" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] focus:bg-white transition-all shadow-sm outline-none py-3.5 px-4">
                                    <x-input-error class="mt-2 text-xs text-red-500 font-bold" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl mt-4">
                                    <p class="text-sm font-bold text-amber-800">
                                        Email Anda belum diverifikasi.
                                        <button form="send-verification" class="underline text-amber-600 hover:text-amber-900 rounded-md focus:outline-none transition-colors">
                                            Klik di sini untuk mengirim ulang email verifikasi.
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-bold font-medium text-sm text-emerald-600"> Tautan verifikasi baru telah dikirimkan ke email Anda.</p>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                                <button type="submit" class="bg-[#2563eb] text-white px-8 py-3.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-[0_10px_20px_rgba(37,99,235,0.2)] hover:bg-blue-700 hover:-translate-y-1 transition-all">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2. UPDATE PASSWORD -->
                <div data-aos="fade-up" data-aos-delay="400" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                    <div class="relative z-10 p-6 sm:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center shrink-0 border border-emerald-100 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <h2 class="font-black text-xl text-slate-800 tracking-tight">Keamanan Sandi</h2>
                                <p class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Pastikan akun Anda menggunakan kata sandi panjang & acak</p>
                            </div>
                        </div>

                        <!-- Form Bawaan Laravel untuk Update Password -->
                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf @method('put')
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password Saat Ini</label>
                                    <input type="password" name="current_password" autocomplete="current-password" class="w-full md:w-2/3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all shadow-sm outline-none py-3.5 px-4" placeholder="••••••••">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs text-red-500 font-bold" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password Baru</label>
                                    <input type="password" name="password" autocomplete="new-password" class="w-full md:w-2/3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all shadow-sm outline-none py-3.5 px-4" placeholder="Ketik kata sandi baru...">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs text-red-500 font-bold" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full md:w-2/3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all shadow-sm outline-none py-3.5 px-4" placeholder="Ulangi kata sandi baru...">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs text-red-500 font-bold" />
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-500 text-white px-8 py-3.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-[0_10px_20px_rgba(16,185,129,0.2)] hover:shadow-[0_15px_30px_rgba(16,185,129,0.3)] hover:-translate-y-1 transition-all">
                                    Perbarui Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- KOLOM KANAN: ID CARD & DANGER ZONE -->
            <!-- ========================================== -->
            <div class="lg:col-span-1 flex flex-col gap-6 sm:gap-8">
                
                <!-- KARTU IDENTITAS VIRTUAL -->
                <div data-aos="fade-up" data-aos-delay="500" class="bg-gradient-to-br from-[#1e3a8a] to-[#2563eb] rounded-3xl p-8 shadow-xl text-white relative overflow-hidden flex flex-col items-center text-center">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                    <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-blue-300 opacity-20 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10 w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-4xl font-black shadow-inner border border-white/30 mb-5">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="relative z-10">
                        <span class="bg-blue-900/50 text-blue-100 px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest mb-3 inline-block border border-blue-400/30">
                            Administrator SPPG
                        </span>
                        <h3 class="font-black text-2xl tracking-wide">{{ $user->name }}</h3>
                        <p class="text-blue-200 text-xs font-bold mt-1 tracking-widest">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- DANGER ZONE (HAPUS AKUN DENGAN MODAL ALPINE) -->
                <div data-aos="fade-up" data-aos-delay="600" class="bg-white rounded-3xl p-6 sm:p-8 border border-red-100 shadow-sm" x-data="{ confirmingUserDeletion: false }">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm text-red-600">Danger Zone</h3>
                    </div>
                    <p class="text-slate-500 text-xs font-bold leading-relaxed mb-6">
                        Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Pastikan Anda mengunduh data apa pun yang ingin Anda pertahankan.
                    </p>
                    <button @click="confirmingUserDeletion = true" class="w-full bg-red-50 text-red-600 hover:bg-red-500 hover:text-white px-4 py-3.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all border border-red-200">
                        Hapus Akun Permanen
                    </button>

                    <!-- MODAL ALPINE HAPUS AKUN -->
                    <template x-teleport="body">
                        <div x-show="confirmingUserDeletion" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                            <!-- Latar Belakang Gelap -->
                            <div x-show="confirmingUserDeletion" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="confirmingUserDeletion = false"></div>
                            
                            <!-- Konten Modal -->
                            <div x-show="confirmingUserDeletion" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90"
                                 class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border-t-4 border-red-500 overflow-hidden">
                                 
                                <h2 class="text-xl font-black text-slate-900 mb-2">Apakah Anda yakin ingin menghapus akun Anda?</h2>
                                <p class="text-xs font-bold text-slate-500 mb-6 leading-relaxed">
                                    Tindakan ini tidak dapat dibatalkan. Harap masukkan kata sandi Anda untuk mengonfirmasi penghapusan.
                                </p>

                                <form method="post" action="{{ route('profile.destroy') }}">
                                    @csrf @method('delete')
                                    <div class="mb-6">
                                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all py-3.5 px-4 outline-none" placeholder="Masukkan password Anda...">
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs text-red-500 font-bold" />
                                    </div>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="confirmingUserDeletion = false" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-colors">Batal</button>
                                        <button type="submit" class="px-5 py-3 rounded-xl bg-red-600 text-white font-black text-[10px] uppercase tracking-widest shadow-[0_5px_15px_rgba(220,38,38,0.3)] hover:bg-red-700 transition-colors">Hapus Akun</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Inisialisasi Animasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> document.addEventListener("DOMContentLoaded", function() { AOS.init({ once: true, offset: 20 }); }); </script>
</x-app-layout>
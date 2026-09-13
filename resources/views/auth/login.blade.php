<x-guest-layout>
    <!-- OVERRIDE DEFAULT LAYOUT: Membuat layar penuh (Full Screen) -->
    <div class="fixed inset-0 z-50 flex bg-white font-sans overflow-hidden">
        
        <!-- Memuat CSS Animasi AOS -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <!-- ========================================== -->
        <!-- PANEL KIRI: VISUAL & BRANDING (Hanya Desktop) -->
        <!-- ========================================== -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] overflow-hidden items-center justify-center">
            
            <!-- Animasi Cahaya Berdenyut di Background -->
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-blue-400 opacity-20 blur-[100px] rounded-full animate-[pulse_6s_ease-in-out_infinite]"></div>
            <div class="absolute bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-white opacity-10 blur-[80px] rounded-full animate-[pulse_8s_ease-in-out_infinite]"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

            <div class="relative z-10 p-12 text-center flex flex-col items-center">
                <!-- Logo -->
                <div data-aos="fade-down" data-aos-duration="1000" class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-[2rem] flex items-center justify-center text-white border border-white/20 shadow-2xl mb-8">
                    <span class="text-5xl font-black">S</span>
                </div>
                <span data-aos="fade-up" data-aos-delay="200" class="px-5 py-2 rounded-full bg-white/10 border border-white/20 text-blue-100 text-[10px] font-black uppercase tracking-[0.3em] mb-6 backdrop-blur-md shadow-sm">
                    Sistem Informasi Terpadu
                </span>
                <h1 data-aos="zoom-out" data-aos-delay="400" data-aos-duration="1200" class="text-5xl xl:text-6xl font-black text-white uppercase tracking-tighter mb-4 drop-shadow-2xl leading-tight">
                    PORTAL <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">SPPG</span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="600" class="max-w-md text-sm text-blue-200 font-medium tracking-wide leading-relaxed">
                    Magelang Borobudur.<br>Kelola gizi, pantau request menu, dan jaga kualitas pelayanan dalam satu genggaman digital.
                </p>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- PANEL KANAN: FORM LOGIN -->
        <!-- ========================================== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 overflow-y-auto relative">
            
            <!-- Dekorasi Melengkung untuk Mobile -->
            <div class="lg:hidden absolute top-0 left-0 w-full h-72 bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] rounded-b-[3rem] z-0 shadow-lg"></div>

            <div class="w-full max-w-md relative z-10 bg-white lg:bg-transparent rounded-[2rem] p-8 lg:p-0 shadow-2xl lg:shadow-none border border-slate-100 lg:border-none" data-aos="fade-up" data-aos-duration="1000">

                <!-- Header Form -->
                <div class="text-center lg:text-left mb-10">
                    <div class="lg:hidden w-16 h-16 mx-auto bg-gradient-to-br from-[#1e3a8a] to-[#2563eb] rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-lg mb-6">S</div>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-2">Selamat Datang!</h2>
                    <p class="text-slate-500 font-medium text-xs sm:text-sm">Silakan masukkan kredensial Anda untuk melanjutkan ke Control Panel.</p>
                </div>

                <!-- Session Status Laravel -->
                <x-auth-session-status class="mb-6 font-bold text-emerald-600 bg-emerald-50 p-4 rounded-xl text-sm" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Kolom Email -->
                    <div data-aos="fade-up" data-aos-delay="200">
                        <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] focus:bg-white transition-all shadow-sm outline-none" placeholder="admin@sppg.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
                    </div>

                    <!-- Kolom Password (dengan Alpine.js Show/Hide) -->
                    <div data-aos="fade-up" data-aos-delay="300">
                        <label for="password" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" class="block w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] focus:bg-white transition-all shadow-sm outline-none" placeholder="••••••••">
                            
                            <!-- Tombol Mata (Toggle Password) -->
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#2563eb] focus:outline-none transition-colors">
                                <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
                    </div>

                    <!-- Ingat Saya & Lupa Password -->
                    <div class="flex items-center justify-between mt-4" data-aos="fade-up" data-aos-delay="400">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#2563eb] shadow-sm focus:ring-[#2563eb] transition-all cursor-pointer">
                            <span class="ml-2 text-xs font-bold text-slate-500 group-hover:text-slate-800 transition-colors">Ingat Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs font-black text-[#2563eb] hover:text-blue-800 hover:underline transition-colors" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <div data-aos="fade-up" data-aos-delay="500" class="pt-4">
                        <button type="submit" class="w-full flex justify-center items-center gap-3 bg-gradient-to-r from-[#1e3a8a] to-[#2563eb] text-white px-6 py-4 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:shadow-[0_15px_30px_rgba(37,99,235,0.4)] hover:-translate-y-1 transition-all">
                            Masuk ke Sistem
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
                
                <!-- Footer Form -->
                <div class="mt-10 text-center" data-aos="fade-up" data-aos-delay="600">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">&copy; 2026 SPPG Magelang Borobudur</p>
                    <a href="{{ url('/') }}" class="inline-block mt-3 text-xs font-black text-slate-400 hover:text-[#2563eb] transition-colors">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inisialisasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({ once: true, offset: 10 });
        });
    </script>
</x-guest-layout>
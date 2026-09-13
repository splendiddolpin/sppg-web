<x-app-layout>
    <!-- Memuat CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style> 
        body, html { background-color: #F8FAFC !important; overflow-x: hidden; scroll-behavior: smooth; } 
        .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%); }
    </style>

    <!-- HERO SECTION (Tanpa Data AKG, Murni Informasi) -->
    <div class="relative bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] pt-24 sm:pt-32 pb-40 overflow-hidden clip-diagonal">
        <!-- Dekorasi Latar Belakang -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-blue-500 opacity-20 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[30%] h-[30%] bg-white opacity-10 blur-[80px] rounded-full"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <span data-aos="fade-down" class="px-4 py-1.5 rounded-sm border border-blue-400/30 text-blue-200 text-[10px] font-black uppercase tracking-[0.3em] mb-4 backdrop-blur-md">
                Pusat Edukasi & SOP
            </span>
            <h1 data-aos="zoom-out" data-aos-duration="1000" class="text-4xl sm:text-6xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4 drop-shadow-2xl">
                REGULASI <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">BGN</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="max-w-2xl mx-auto text-xs sm:text-sm md:text-base text-blue-200 font-medium tracking-wide mb-8">
                Pembaruan instruksi bahan pangan, larangan menu, dan pedoman gizi dari Badan Gizi Nasional untuk menjaga kesehatan Penerima Manfaat.
            </p>
            
            <a href="{{ url('/') }}" data-aos="fade-up" data-aos-delay="300" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all hover:-translate-y-1 backdrop-blur-sm shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT (KUMPULAN ATURAN INTERAKTIF) -->
    <div class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 sm:-mt-20 pb-20">
        
        <div class="mb-6 flex items-center justify-between bg-white px-6 py-4 rounded-2xl shadow-sm border border-slate-100">
            <h2 class="font-black text-slate-800 uppercase tracking-widest text-sm">Daftar Instruksi & Larangan</h2>
            <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-100">Wajib Dipatuhi</span>
        </div>

        <!-- STATE ALPINE UNTUK AKORDION/SLIDE DOWN CARDS -->
        <div x-data="{ activeCard: null }" class="flex flex-col gap-4">
            
            <!-- KARTU 1: LARANGAN SUSU -->
            <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-300" :class="activeCard === 1 ? 'ring-2 ring-[#2563eb] shadow-xl' : 'hover:border-blue-300 hover:shadow-md'">
                <!-- Header Kartu (Yang Diklik) -->
                <div @click="activeCard = activeCard === 1 ? null : 1" class="cursor-pointer p-6 sm:p-8 flex items-center justify-between group">
                    <div class="flex items-center gap-5 sm:gap-6">
                        <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center shrink-0 border border-red-100 group-hover:bg-red-500 group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Instruksi Medis</p>
                            <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-wide group-hover:text-[#2563eb] transition-colors">Larangan Penggunaan Susu Sapi</h3>
                        </div>
                    </div>
                    <!-- Ikon Panah Putar -->
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-[#2563eb] group-hover:bg-blue-50 transition-colors">
                        <svg class="w-5 h-5 transition-transform duration-500" :class="activeCard === 1 ? 'rotate-180 text-[#2563eb]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Detail Kartu (Muncul dengan Animasi Smooth) -->
                <div x-show="activeCard === 1" 
                     x-transition:enter="transition-all ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
                     x-transition:enter-end="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave="transition-all ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave-end="opacity-0 -translate-y-4 max-h-0"
                     style="display: none;">
                     
                    <div class="px-6 pb-8 sm:px-8">
                        <div class="bg-slate-50 border-t-4 border-red-500 p-6 rounded-2xl">
                            <h4 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-3">Alasan Kebijakan:</h4>
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 font-medium">Susu sapi murni memiliki risiko tinggi memicu <strong class="text-red-500">Intoleransi Laktosa</strong> pada anak-anak yang pencernaannya belum terbiasa. Hal ini kerap menyebabkan diare, kembung, dan sakit perut massal pada penerima manfaat.</p>
                            
                            <h4 class="font-black text-[#2563eb] text-sm uppercase tracking-widest mb-3 border-b border-slate-200 pb-2">Solusi & Alternatif BGN:</h4>
                            <ul class="space-y-3 text-sm text-slate-600 font-bold">
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Gunakan Susu Kedelai murni (Soya) tanpa pemanis buatan berlebih.</li>
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Ganti pemenuhan kalsium melalui protein hewani lainnya (Ikan Teri, Telur) atau nabati (Tahu, Tempe).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: LARANGAN MIE -->
            <div data-aos="fade-up" data-aos-delay="300" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-300" :class="activeCard === 2 ? 'ring-2 ring-[#2563eb] shadow-xl' : 'hover:border-blue-300 hover:shadow-md'">
                <div @click="activeCard = activeCard === 2 ? null : 2" class="cursor-pointer p-6 sm:p-8 flex items-center justify-between group">
                    <div class="flex items-center gap-5 sm:gap-6">
                        <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center shrink-0 border border-amber-100 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Gizi Seimbang</p>
                            <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-wide group-hover:text-[#2563eb] transition-colors">Larangan Olahan Mie / Pasta</h3>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-[#2563eb] group-hover:bg-blue-50 transition-colors">
                        <svg class="w-5 h-5 transition-transform duration-500" :class="activeCard === 2 ? 'rotate-180 text-[#2563eb]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div x-show="activeCard === 2" 
                     x-transition:enter="transition-all ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
                     x-transition:enter-end="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave="transition-all ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave-end="opacity-0 -translate-y-4 max-h-0"
                     style="display: none;">
                     
                    <div class="px-6 pb-8 sm:px-8">
                        <div class="bg-slate-50 border-t-4 border-amber-500 p-6 rounded-2xl">
                            <h4 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-3">Alasan Kebijakan:</h4>
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 font-medium">Mie instan maupun mie basah komersial termasuk dalam kategori <strong class="text-amber-500">Makanan Ultra-Proses</strong> yang mengandung natrium (garam) dan pengawet tinggi, serta memiliki nilai gizi (vitamin/mineral) yang sangat rendah dibanding porsi kalorinya.</p>
                            
                            <h4 class="font-black text-[#2563eb] text-sm uppercase tracking-widest mb-3 border-b border-slate-200 pb-2">Solusi & Alternatif BGN:</h4>
                            <ul class="space-y-3 text-sm text-slate-600 font-bold">
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Wajib menggunakan karbohidrat kompleks alami lokal.</li>
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Ganti olahan mie dengan: Beras merah, Nasi Jagung, Ubi jalar rebus, Singkong, atau Kentang panggang.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 3: LARANGAN SANTAN -->
            <div data-aos="fade-up" data-aos-delay="400" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-300" :class="activeCard === 3 ? 'ring-2 ring-[#2563eb] shadow-xl' : 'hover:border-blue-300 hover:shadow-md'">
                <div @click="activeCard = activeCard === 3 ? null : 3" class="cursor-pointer p-6 sm:p-8 flex items-center justify-between group">
                    <div class="flex items-center gap-5 sm:gap-6">
                        <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center shrink-0 border border-orange-100 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-500 transition-colors">Keamanan Pangan</p>
                            <h3 class="text-lg sm:text-xl font-black text-slate-800 uppercase tracking-wide group-hover:text-[#2563eb] transition-colors">Larangan Ekstrak Santan Kelapa</h3>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-[#2563eb] group-hover:bg-blue-50 transition-colors">
                        <svg class="w-5 h-5 transition-transform duration-500" :class="activeCard === 3 ? 'rotate-180 text-[#2563eb]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div x-show="activeCard === 3" 
                     x-transition:enter="transition-all ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
                     x-transition:enter-end="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave="transition-all ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 max-h-screen"
                     x-transition:leave-end="opacity-0 -translate-y-4 max-h-0"
                     style="display: none;">
                     
                    <div class="px-6 pb-8 sm:px-8">
                        <div class="bg-slate-50 border-t-4 border-orange-500 p-6 rounded-2xl">
                            <h4 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-3">Alasan Kebijakan:</h4>
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 font-medium">Santan kelapa sangat <strong class="text-orange-500">rentan basi (rusak)</strong> jika didistribusikan secara massal dengan jeda waktu panjang. Selain itu, konsumsi santan berlebih pada anak dapat memicu peningkatan asam lambung yang signifikan.</p>
                            
                            <h4 class="font-black text-[#2563eb] text-sm uppercase tracking-widest mb-3 border-b border-slate-200 pb-2">Solusi & Alternatif BGN:</h4>
                            <ul class="space-y-3 text-sm text-slate-600 font-bold">
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Untuk kuah sayur atau lauk, gunakan teknik rebusan kaldu tulang murni (ayam/sapi) yang dimasak perlahan.</li>
                                <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Untuk mengejar tekstur 'gurih' pada kuah, tambahkan bumbu Kemiri Sangrai yang dihaluskan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Script Inisialisasi Animasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> document.addEventListener("DOMContentLoaded", function() { AOS.init({ once: true, offset: 50 }); }); </script>
</x-app-layout>
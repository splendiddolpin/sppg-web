<x-app-layout>
    <!-- Memuat CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style> 
        body, html { background-color: #F8FAFC !important; overflow-x: hidden; scroll-behavior: smooth; } 
        .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%); }
        .modal-scroll::-webkit-scrollbar { width: 6px; }
        .modal-scroll::-webkit-scrollbar-track { background: transparent; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body { padding-bottom: 120px; }
    </style>

    @php
        $menuKatalog = \App\Models\MenuItem::orderBy('kategori', 'asc')->orderBy('nama', 'asc')->get();
        $kategoriList = $menuKatalog->pluck('kategori')->unique();
    @endphp

    @if(session('success'))
        <div class="fixed top-24 right-4 sm:right-8 bg-white border-l-4 border-[#2563eb] text-slate-800 px-6 py-4 shadow-[0_10px_40px_rgba(0,0,0,0.1)] font-bold flex items-center gap-3 z-[100] animate-bounce rounded-r-lg">
            <svg class="w-5 h-5 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- HERO SECTION -->
    <div class="relative bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] pt-24 sm:pt-32 pb-40 overflow-hidden clip-diagonal">
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-blue-500 opacity-20 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[30%] h-[30%] bg-white opacity-10 blur-[80px] rounded-full"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <h1 data-aos="zoom-out" data-aos-duration="1000" class="text-4xl sm:text-6xl md:text-7xl font-black text-white uppercase tracking-tighter mb-4 drop-shadow-2xl">
                REQUEST <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">MENU</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="max-w-xl mx-auto text-xs sm:text-sm md:text-base text-blue-200 font-medium tracking-wide">
                Silakan lengkapi pesanan Anda. Anda WAJIB memilih 1 menu dari setiap kategori tanpa melewati batas anggaran Rp 10.000.
            </p>
        </div>
    </div>

    <!-- ALPINE.JS STATE (Clean Version) -->
    <div x-data="menuApp()" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        
        <form action="{{ route('request-menu.store') }}" method="POST" id="form-pengajuan">
            @csrf
            <input type="hidden" name="nama_menu" :value="menuString">
            <input type="hidden" name="ukuran_porsi" value="Standar">

            <!-- FILTER & SEARCH BAR -->
            <div data-aos="fade-up" data-aos-delay="300" class="bg-white/90 backdrop-blur-md shadow-[0_10px_30px_rgba(0,0,0,0.06)] border border-white/50 rounded-3xl p-5 sm:p-6 flex flex-col gap-6 -mt-12 mb-12 relative z-30 mx-auto w-full max-w-5xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-2 px-2">
                        <svg class="w-5 h-5 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span class="text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest">Filter & Cari Menu</span>
                    </div>
                    
                    <div class="w-full md:w-80 shrink-0 relative">
                        <div class="bg-slate-50 border border-slate-200 rounded-full overflow-hidden flex items-center px-4 py-1 transition-all focus-within:ring-2 focus-within:ring-[#2563eb] shadow-inner">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input x-model="search" type="text" placeholder="Ketik nama menu..." class="w-full bg-transparent border-none focus:ring-0 px-3 py-2.5 text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-800 outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 sm:gap-3">
                    <button type="button" @click="filter = 'Semua'" :class="filter === 'Semua' ? 'bg-[#2563eb] text-white shadow-md border-[#2563eb]' : 'bg-white text-slate-500 border-slate-200 hover:border-[#2563eb] hover:text-[#2563eb]'" class="px-5 py-2.5 rounded-full border font-black text-[10px] sm:text-xs uppercase tracking-widest transition-all duration-300 shadow-sm">Semua Menu</button>
                    @foreach($kategoriList as $kat)
                        <button type="button" @click="filter = '{{ $kat }}'" :class="filter === '{{ $kat }}' ? 'bg-[#2563eb] text-white shadow-md border-[#2563eb]' : 'bg-white text-slate-500 border-slate-200 hover:border-[#2563eb] hover:text-[#2563eb]'" class="px-5 py-2.5 rounded-full border font-black text-[10px] sm:text-xs uppercase tracking-widest transition-all duration-300 shadow-sm flex items-center gap-2">
                            {{ $kat }}
                            <svg x-show="cart.map(i => i.kategori).includes('{{ $kat }}')" class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- GRID KARTU MENU -->
            <div data-aos="fade-up" data-aos-delay="400" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mb-16">
                @forelse($menuKatalog as $item)
                    <div x-show="(filter === 'Semua' || filter === '{{ $item->kategori }}') && '{{ strtolower($item->nama) }}'.includes(search.toLowerCase())"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         @click="toggleItem('{{ $item->id }}', '{{ $item->nama }}', {{ $item->harga }}, '{{ $item->kategori }}')"
                         class="relative bg-gradient-to-br from-white to-slate-50/50 rounded-3xl border-2 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col group"
                         :class="inCart('{{ $item->id }}') ? 'border-[#2563eb] ring-4 ring-blue-600/10 shadow-[0_15px_40px_rgba(37,99,235,0.15)]' : 'border-slate-100 hover:border-blue-300 hover:shadow-xl hover:-translate-y-1'">

                        <div class="absolute inset-0 bg-blue-50/60 opacity-0 transition-opacity duration-300 z-0" :class="inCart('{{ $item->id }}') ? 'opacity-100' : ''"></div>

                        <div class="flex justify-between items-center p-4 sm:p-5 pb-0 z-10">
                            <span class="text-[9px] font-black uppercase tracking-widest transition-colors duration-300" :class="inCart('{{ $item->id }}') ? 'text-[#2563eb]' : 'text-slate-400 group-hover:text-blue-500'">{{ $item->kategori }}</span>
                            <span class="text-[10px] font-black px-2 py-1 rounded-lg transition-colors duration-300" :class="inCart('{{ $item->id }}') ? 'bg-[#2563eb] text-white shadow-sm' : 'bg-slate-100 text-slate-600 group-hover:bg-blue-100 group-hover:text-blue-700'">Rp {{ number_format($item->harga, 0,',','.') }}</span>
                        </div>

                        <div class="flex-grow flex flex-col items-center justify-center p-4 sm:p-6 text-center z-10 relative overflow-hidden">
                            <h2 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-8xl sm:text-[110px] font-black text-transparent bg-clip-text bg-gradient-to-br from-slate-100 to-slate-200 select-none group-hover:from-blue-50 group-hover:to-blue-100 transition-all duration-500 group-hover:scale-110 z-0">
                                {{ substr($item->nama, 0, 1) }}
                            </h2>
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full flex items-center justify-center mb-3 sm:mb-4 transition-all duration-300 relative z-10"
                                 :class="inCart('{{ $item->id }}') ? 'bg-[#2563eb] text-white scale-110 shadow-[0_10px_25px_rgba(37,99,235,0.4)]' : 'bg-white/80 backdrop-blur-sm border border-slate-100 text-slate-300 shadow-sm group-hover:bg-white group-hover:text-blue-500'">
                                <svg x-show="inCart('{{ $item->id }}')" style="display: none;" class="w-7 h-7 sm:w-8 sm:h-8 animate-[pulse_0.3s_ease-in-out]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                <svg x-show="!inCart('{{ $item->id }}')" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="font-black text-xs sm:text-sm leading-snug transition-colors duration-300 uppercase tracking-wide relative z-10"
                                :class="inCart('{{ $item->id }}') ? 'text-[#1e3a8a]' : 'text-slate-800 group-hover:text-[#2563eb]'">
                                {{ $item->nama }}
                            </h3>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center"><p class="text-slate-400 font-bold uppercase tracking-widest">Katalog Kosong</p></div>
                @endforelse
            </div>

            <!-- ========================================== -->
            <!-- KERANJANG PINTAR -->
            <!-- ========================================== -->
            
            <div x-show="cartOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;" @click="cartOpen = false" 
                 class="fixed inset-0 bg-[#0f172a]/60 backdrop-blur-sm z-[80]"></div>

            <div class="fixed bottom-0 left-0 w-full z-[90] flex flex-col items-center px-2 sm:px-8 pb-4 pointer-events-none">
                
                <div x-show="cartOpen" 
                     x-transition:enter="transition transform duration-500"
                     x-transition:enter-start="translate-y-full opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     x-transition:leave="transition transform duration-400 ease-in"
                     x-transition:leave-start="translate-y-0 opacity-100"
                     x-transition:leave-end="translate-y-full opacity-0"
                     style="display: none; transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);" 
                     class="w-full max-w-4xl bg-white/95 backdrop-blur-xl rounded-t-[32px] shadow-[0_-20px_60px_rgba(0,0,0,0.15)] overflow-hidden flex flex-col max-h-[85vh] border border-white/50 mb-[-10px] pb-4 pointer-events-auto">
                    
                    <div class="px-6 py-5 border-b border-slate-200/50 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Form & Keranjang Anda
                        </h3>
                        <button type="button" @click="cartOpen = false" class="text-slate-400 hover:text-slate-900 bg-white shadow-sm border border-slate-200 p-1.5 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>

                    <div class="flex-grow overflow-y-auto modal-scroll">
                        
                        <div x-show="!isCartComplete" class="bg-amber-50 px-6 py-4 border-b border-amber-100 flex flex-col sm:flex-row gap-2 sm:items-center">
                            <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 shrink-0">Belum Terpilih:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="cat in missingCategories">
                                    <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider" x-text="cat"></span>
                                </template>
                            </div>
                        </div>

                        <div class="px-6 pt-6 pb-4">
                            <div class="flex justify-between items-end mb-3">
                                <div>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1">Total Komponen Isi Menu</span>
                                    <span class="text-xl font-black text-slate-900" x-text="formatRp(totalHargaItem)"></span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-1">Maksimal Anggaran Flat</span>
                                    <span class="text-xs font-black text-[#2563eb] bg-blue-50 px-2 py-1 rounded-md border border-[#bfdbfe]" x-text="formatRp(maxBudget)"></span>
                                </div>
                            </div>
                            <div class="h-2 w-full bg-slate-200/50 rounded-full overflow-hidden shadow-inner">
                                <div class="h-full transition-all duration-500 ease-out" :class="isOverBudget ? 'bg-red-500' : 'bg-gradient-to-r from-blue-500 to-blue-600'" :style="'width: ' + percentage + '%'"></div>
                            </div>
                        </div>

                        <div class="px-6 py-2 border-b border-slate-100 pb-6 min-h-[120px]">
                            <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center opacity-30 py-6">
                                <svg class="w-10 h-10 mb-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-600">Anda belum memilih menu</p>
                            </div>
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 last:border-0 hover:bg-blue-50/30 rounded-lg px-2 -mx-2 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 shadow-sm flex items-center justify-center shrink-0 text-slate-400">
                                            <span class="font-black text-xs" x-text="item.nama.charAt(0)"></span>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black text-blue-500 mb-0.5 uppercase tracking-widest" x-text="item.kategori"></p>
                                            <p class="text-xs font-black text-slate-800 uppercase" x-text="item.nama"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <p class="text-[10px] font-bold text-slate-500" x-text="formatRp(item.harga)"></p>
                                        <button type="button" @click="removeItem(item.id)" class="text-slate-300 hover:text-red-500 hover:bg-red-50 p-2 rounded-md transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="px-6 py-6 bg-slate-50/50">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Lengkapi Data Pengiriman</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Nama Pemohon <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_pemohon" x-model="nama_pemohon" required class="w-full rounded-xl bg-white border border-slate-200 text-slate-900 text-xs font-bold px-4 py-3 focus:border-[#2563eb] outline-none shadow-sm" placeholder="Cth: Bpk. Budi">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Tanggal <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_kebutuhan" x-model="tanggal_kebutuhan" required class="w-full rounded-xl bg-white border border-slate-200 text-slate-900 text-xs font-bold px-4 py-3 focus:border-[#2563eb] outline-none shadow-sm">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Jmlh Porsi Total <span class="text-red-500">*</span></label>
                                    <input type="number" name="jumlah" x-model.number="jumlah" min="1" required class="w-full rounded-xl bg-white border border-slate-200 text-slate-900 text-xs font-bold px-4 py-3 focus:border-[#2563eb] outline-none shadow-sm">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sticky Bottom Bar -->
                <div class="w-full max-w-4xl bg-[#0f172a]/85 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border border-white/10 rounded-[24px] relative overflow-hidden mt-2 pointer-events-auto">
                    
                    <div x-show="isOverBudget" x-transition class="bg-red-500/90 text-white text-[10px] font-black uppercase tracking-widest text-center py-2 backdrop-blur-md">
                        Peringatan: Melebihi batas maksimal anggaran (Rp 10.000)!
                    </div>

                    <div class="px-5 sm:px-8 py-4 sm:py-5 flex justify-between items-center relative z-10">
                        <div @click="cartOpen = !cartOpen" class="cursor-pointer group flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="text-slate-400 text-[9px] sm:text-[10px] uppercase font-black tracking-widest group-hover:text-blue-300 transition-colors">Total Estimasi <span class="bg-white/10 px-2 py-0.5 rounded text-white ml-2" x-text="cart.length + ' / ' + allCategories.length + ' Komponen'"></span></p>
                                <div class="w-5 h-5 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-blue-500/20 transition-colors">
                                    <svg class="w-3 h-3 text-slate-400 group-hover:text-blue-300 transition-transform duration-500" :class="cartOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-black text-white drop-shadow-md" x-text="formatRp(totalKeseluruhan)"></h3>
                        </div>
                        
                        <button :type="canSubmit ? 'submit' : 'button'" 
                                @click="if(!canSubmit) cartOpen = true"
                                :class="!canSubmit ? 'bg-white/10 text-white hover:bg-white/20 border border-white/10' : 'bg-gradient-to-r from-[#2563eb] to-[#1d4ed8] text-white hover:scale-105 shadow-[0_0_20px_rgba(37,99,235,0.5)] border border-blue-400/50'"
                                class="font-black text-[9px] sm:text-xs uppercase tracking-widest px-4 sm:px-8 py-3.5 sm:py-4 rounded-xl transition-all duration-300 transform shrink-0 flex items-center gap-2">
                            
                            <span x-text="!isCartComplete ? `Pilih ${missingCategories.length} Lagi` : (!isFormValid ? 'Isi Data' : 'KIRIM REQUEST')"></span>
                            
                            <svg x-show="canSubmit" class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
                
            </div>
        </form>
    </div>

    <!-- Script Alpine.js Data & Inisialisasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            AOS.init({ once: true, offset: 50 }); 
        });

        function menuApp() {
            return {
                filter: 'Semua', 
                search: '',
                cart: [],
                jumlah: 1,
                nama_pemohon: '',
                tanggal_kebutuhan: '',
                maxBudget: 10000, 
                cartOpen: false,
                allCategories: @json($kategoriList->values()),
                
                get totalHargaItem() { return this.cart.reduce((sum, item) => sum + item.harga, 0); },
                get totalKeseluruhan() { return this.totalHargaItem * (this.jumlah || 1); },
                get isOverBudget() { return this.totalHargaItem > this.maxBudget; },
                get percentage() { return Math.min((this.totalHargaItem / this.maxBudget) * 100, 100); },
                get menuString() { return this.cart.map(i => i.nama).join(', '); },
                
                get missingCategories() {
                    let selectedCats = this.cart.map(i => i.kategori);
                    return this.allCategories.filter(c => !selectedCats.includes(c));
                },
                get isCartComplete() { return this.missingCategories.length === 0; },
                get isFormValid() { return this.nama_pemohon.trim() !== '' && this.tanggal_kebutuhan !== '' && this.jumlah > 0; },
                get canSubmit() { return this.isCartComplete && this.isFormValid && !this.isOverBudget; },
                
                toggleItem(id, nama, harga, kategori) {
                    const index = this.cart.findIndex(i => i.id === id);
                    if (index > -1) {
                        this.cart.splice(index, 1);
                    } else {
                        const catIndex = this.cart.findIndex(i => i.kategori === kategori);
                        if (catIndex > -1) this.cart.splice(catIndex, 1);
                        this.cart.push({ id, nama, harga: parseInt(harga), kategori });
                    }
                },
                
                removeItem(id) { this.cart = this.cart.filter(i => i.id !== id); },
                inCart(id) { return this.cart.some(i => i.id === id); },
                formatRp(angka) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka); }
            }
        }
    </script>
</x-app-layout>
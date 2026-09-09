<x-app-layout>
    <style> body, html { background-color: #F8FAFC !important; } </style>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="fixed top-24 right-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-lg font-bold flex items-center gap-3 z-50 animate-bounce">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Hero Section -->
    <div class="relative bg-[#F8FAFC] pt-16 pb-12 lg:pt-24 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">Profil SPPG</span>
                <span class="block text-blue-600">Magelang Borobudur</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Sistem Informasi Terpadu untuk pemantauan AKG, Request Menu, Indikator Kinerja, dan Pengelolaan Kas secara transparan.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Grid Atas: Profil & AKG -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                
                <!-- Card Profil -->
                <div class="bg-gray-50 rounded-3xl shadow-sm p-8 border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Profil SPPG</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">
                        SPPG Magelang Borobudur merupakan pusat pengelolaan operasional yang berdedikasi untuk memberikan layanan terbaik. Bagian ini nantinya dapat diisi dengan sejarah, visi, misi, serta struktur organisasi.
                    </p>
                </div>

                <!-- Card AKG Interaktif dengan Alpine.js -->
                <div x-data="{ 
                        porsi: 'Kecil', 
                        akgKecil: {{ $akgKecil->toJson() }}, 
                        akgBesar: {{ $akgBesar->toJson() }},
                        get data() { return this.porsi === 'Kecil' ? this.akgKecil : this.akgBesar; },
                        isEditOpen: false,
                        editTab: 'Kecil'
                     }" 
                     class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col relative overflow-hidden">
                    
                    <!-- Header Card AKG -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 flex justify-between items-center text-white relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3">
                                <h3 class="text-xl font-black">AKG Menu Hari Ini</h3>
                                <!-- Tombol Edit (Muncul Jika Login) -->
                                @auth
                                    <button @click="isEditOpen = true" class="bg-white/20 hover:bg-white px-3 py-1 rounded-full text-xs font-bold text-white hover:text-blue-700 transition-all shadow-sm flex items-center gap-1 backdrop-blur-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </button>
                                @endauth
                            </div>
                            
                            <div class="mt-4 flex gap-1 bg-blue-800/50 p-1 rounded-full w-max backdrop-blur-sm border border-blue-500/30">
                                <button @click="porsi = 'Kecil'" :class="porsi === 'Kecil' ? 'bg-white text-blue-700 shadow-sm' : 'text-blue-100 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Porsi Kecil</button>
                                <button @click="porsi = 'Besar'" :class="porsi === 'Besar' ? 'bg-white text-blue-700 shadow-sm' : 'text-blue-100 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all">Porsi Besar</button>
                            </div>
                        </div>
                        <div class="text-right relative z-10">
                            <p class="text-blue-200 text-[10px] uppercase tracking-widest font-bold">Tanggal</p>
                            <p class="font-black text-sm">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Konten Data Nutrisi Dinamis -->
                    <div class="p-6 flex-grow flex flex-col justify-between bg-white">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-orange-50 rounded-2xl p-4 border border-orange-100">
                                <span class="text-[10px] font-black uppercase tracking-wider text-orange-500">Energi</span>
                                <div class="text-2xl font-black text-gray-900 mt-1"><span x-text="data.energi"></span> <span class="text-xs text-gray-400">kkal</span></div>
                            </div>
                            <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
                                <span class="text-[10px] font-black uppercase tracking-wider text-blue-600">Karbohidrat</span>
                                <div class="text-2xl font-black text-gray-900 mt-1"><span x-text="data.karbohidrat"></span> <span class="text-xs text-gray-400">g</span></div>
                            </div>
                            <div class="bg-red-50 rounded-2xl p-4 border border-red-100">
                                <span class="text-[10px] font-black uppercase tracking-wider text-red-500">Protein</span>
                                <div class="text-2xl font-black text-gray-900 mt-1"><span x-text="data.protein"></span> <span class="text-xs text-gray-400">g</span></div>
                            </div>
                            <div class="bg-yellow-50 rounded-2xl p-4 border border-yellow-100">
                                <span class="text-[10px] font-black uppercase tracking-wider text-yellow-600">Lemak</span>
                                <div class="text-2xl font-black text-gray-900 mt-1"><span x-text="data.lemak"></span> <span class="text-xs text-gray-400">g</span></div>
                            </div>
                            <div class="bg-purple-50 rounded-2xl p-4 border border-purple-100 col-span-2 flex justify-between items-center">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-wider text-purple-500">Serat</span>
                                    <div class="text-2xl font-black text-gray-900 mt-1"><span x-text="data.serat"></span> <span class="text-xs text-gray-400">g</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto bg-gray-50 border border-gray-200 text-gray-700 rounded-2xl p-4 flex items-center justify-center shadow-sm">
                            <span class="text-sm font-bold mr-2">Total Produksi:</span>
                            <span class="text-2xl font-black text-blue-600"><span x-text="data.total_produksi"></span> Porsi</span>
                        </div>
                    </div>

                    <!-- MODAL EDIT AKG (Hanya Muncul Jika Admin Klik Edit) -->
                    @auth
                    <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
                        <div x-show="isEditOpen" x-transition.opacity class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="isEditOpen = false"></div>
                        
                        <div x-show="isEditOpen" x-transition.scale class="relative bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden m-4">
                            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center text-white">
                                <h3 class="font-black text-lg">Edit Nilai AKG</h3>
                                <button @click="isEditOpen = false" class="text-blue-200 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>

                            <div class="flex bg-gray-50 border-b border-gray-200 px-4 pt-4 gap-2">
                                <button @click="editTab = 'Kecil'" :class="editTab === 'Kecil' ? 'bg-white border-t border-l border-r border-gray-200 text-blue-600' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors">Porsi Kecil</button>
                                <button @click="editTab = 'Besar'" :class="editTab === 'Besar' ? 'bg-white border-t border-l border-r border-gray-200 text-blue-600' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors">Porsi Besar</button>
                            </div>

                            <div class="p-6">
                                <form x-show="editTab === 'Kecil'" action="{{ route('akg.update', $akgKecil->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div><label class="text-xs font-bold text-gray-500">Energi (kkal)</label><input type="number" step="0.1" name="energi" value="{{ $akgKecil->energi }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Karbohidrat (g)</label><input type="number" step="0.1" name="karbohidrat" value="{{ $akgKecil->karbohidrat }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Protein (g)</label><input type="number" step="0.1" name="protein" value="{{ $akgKecil->protein }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Lemak (g)</label><input type="number" step="0.1" name="lemak" value="{{ $akgKecil->lemak }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Serat (g)</label><input type="number" step="0.1" name="serat" value="{{ $akgKecil->serat }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-blue-600">Total Produksi</label><input type="number" name="total_produksi" value="{{ $akgKecil->total_produksi }}" class="w-full rounded-lg border-blue-300 bg-blue-50 mt-1 font-bold"></div>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700">Simpan Porsi Kecil</button>
                                </form>

                                <form x-show="editTab === 'Besar'" action="{{ route('akg.update', $akgBesar->id) }}" method="POST" style="display: none;">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div><label class="text-xs font-bold text-gray-500">Energi (kkal)</label><input type="number" step="0.1" name="energi" value="{{ $akgBesar->energi }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Karbohidrat (g)</label><input type="number" step="0.1" name="karbohidrat" value="{{ $akgBesar->karbohidrat }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Protein (g)</label><input type="number" step="0.1" name="protein" value="{{ $akgBesar->protein }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Lemak (g)</label><input type="number" step="0.1" name="lemak" value="{{ $akgBesar->lemak }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-gray-500">Serat (g)</label><input type="number" step="0.1" name="serat" value="{{ $akgBesar->serat }}" class="w-full rounded-lg border-gray-200 mt-1 font-bold"></div>
                                        <div><label class="text-xs font-bold text-blue-600">Total Produksi</label><input type="number" name="total_produksi" value="{{ $akgBesar->total_produksi }}" class="w-full rounded-lg border-blue-300 bg-blue-50 mt-1 font-bold"></div>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700">Simpan Porsi Besar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Bagian Bawah: Instagram Feed -->
            <div class="bg-gray-50 rounded-3xl shadow-sm p-8 border border-gray-100 w-full overflow-hidden transition duration-300 hover:shadow-md">
                <!-- Header IG -->
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 rounded-2xl flex shrink-0 items-center justify-center text-white shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="text-xl font-black text-gray-900 truncate">@sppg.magelangborobudur</h3>
                        <a href="https://www.instagram.com/sppg.magelangborobudur/" target="_blank" class="text-sm font-bold text-blue-600 hover:text-blue-700 hover:underline">Lihat di Instagram &rarr;</a>
                    </div>
                </div>
                
                <div class="w-full relative rounded-2xl overflow-hidden border border-gray-200/60 bg-white">
                    <div class="sk-instagram-feed w-full" data-embed-id="25712216"></div>
                    <script src="https://widgets.sociablekit.com/instagram-feed/widget.js" defer></script>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
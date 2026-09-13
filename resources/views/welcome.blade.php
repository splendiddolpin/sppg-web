<x-app-layout>
    <!-- Memuat CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style> 
        body, html { background-color: #F1F5F9 !important; overflow-x: hidden; } 
        .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%); }
    </style>

    @if(session('success'))
        <div class="fixed top-24 right-8 bg-white border-l-4 border-[#2563eb] text-gray-800 px-6 py-4 shadow-[0_10px_40px_rgba(0,0,0,0.1)] font-bold flex items-center gap-3 z-[9999] animate-bounce">
            <svg class="w-5 h-5 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- HERO SECTION -->
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 pt-32 pb-48 lg:pt-48 lg:pb-64 overflow-hidden clip-diagonal">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-blue-400 opacity-20 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-white opacity-10 blur-[100px] rounded-full"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <span data-aos="fade-down" data-aos-duration="1000" class="px-4 py-1.5 rounded-full bg-blue-500/30 border border-blue-400/30 text-blue-100 text-xs font-black uppercase tracking-[0.2em] mb-6 backdrop-blur-md">
                Sistem Informasi Terpadu
            </span>
            <h1 data-aos="zoom-out" data-aos-duration="1200" class="text-5xl md:text-7xl lg:text-8xl font-black text-white uppercase tracking-tighter mb-4 drop-shadow-2xl">
                Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">SPPG</span>
            </h1>
            <h2 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200" class="text-2xl md:text-4xl font-bold text-blue-200 tracking-wide mb-8">
                MAGELANG BOROBUDUR
            </h2>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400" class="max-w-2xl mx-auto text-base md:text-lg text-blue-100/80 font-medium">
                Pemantauan Angka Kecukupan Gizi (AKG), Request Menu, dan Pengelolaan Indikator Kinerja yang transparan dan akurat.
            </p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 lg:-mt-40 pb-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            
            <!-- CARD PROFIL -->
            <div data-aos="fade-up" data-aos-delay="300" class="group bg-white rounded-2xl shadow-xl hover:shadow-[0_20px_50px_rgba(37,99,235,0.15)] border border-gray-100 p-8 lg:p-10 transition-all duration-500 transform hover:-translate-y-2 flex flex-col justify-center">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-blue-600 text-xs font-black uppercase tracking-widest">Tentang Kami</p>
                        <h3 class="text-3xl font-black text-gray-900">Profil SPPG</h3>
                    </div>
                </div>
                <div class="w-12 h-1 bg-gray-200 mb-6 group-hover:bg-blue-600 group-hover:w-24 transition-all duration-500"></div>
                <p class="text-gray-600 leading-relaxed font-medium text-lg">
                    SPPG Magelang Borobudur merupakan pusat pengelolaan operasional yang berdedikasi untuk memberikan layanan terbaik. Mengintegrasikan teknologi untuk transparansi data gizi dan kepuasan pelayanan secara menyeluruh.
                </p>
            </div>

            <!-- CARD AKG -->
            <div data-aos="fade-up" data-aos-delay="500" 
                 x-data="{ 
                    porsi: 'Kecil', 
                    akgKecil: {{ $akgKecil->toJson() }}, 
                    akgBesar: {{ $akgBesar->toJson() }},
                    get data() { return this.porsi === 'Kecil' ? this.akgKecil : this.akgBesar; },
                    
                    isEditOpen: false,
                    editTab: 'Kecil',
                    
                    isAnimating: false,
                    switchPorsi(newPorsi) {
                        if (this.porsi === newPorsi) return;
                        this.isAnimating = true;
                        setTimeout(() => {
                            this.porsi = newPorsi;
                            this.isAnimating = false;
                        }, 250);
                    },

                    infoModalOpen: false,
                    activeNutrient: 'energi',
                    nutrientsInfo: {
                        energi: { title: 'Energi (Kalori)', desc: 'Energi atau kalori adalah bahan bakar utama tubuh untuk mendukung semua aktivitas fisik dan fungsi organ internal setiap hari.', unit: 'kkal' },
                        karbohidrat: { title: 'Karbohidrat', desc: 'Sumber tenaga instan yang paling cepat diolah oleh tubuh. Sangat krusial untuk menjaga stamina, fungsi otak, dan sistem saraf.', unit: 'g' },
                        protein: { title: 'Protein', desc: 'Bahan pembangun utama untuk otot, tulang, kulit, dan darah. Sangat penting untuk proses pemulihan dan perbaikan sel tubuh.', unit: 'g' },
                        lemak: { title: 'Lemak', desc: 'Penyimpan energi cadangan, melindungi organ vital, dan membantu penyerapan vitamin ke dalam tubuh.', unit: 'g' },
                        serat: { title: 'Serat', desc: 'Sangat vital untuk kesehatan pencernaan, membantu mengontrol lonjakan gula darah, dan memberikan rasa kenyang.', unit: 'g' }
                    },
                    openInfo(type) {
                        this.activeNutrient = type;
                        this.infoModalOpen = true;
                    },

                    formatTanggal(dateString) {
                        if(!dateString) return '';
                        const d = new Date(dateString);
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                        return d.getDate().toString().padStart(2, '0') + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                    }
                 }" 
                 class="group bg-white rounded-2xl shadow-xl hover:shadow-[0_20px_50px_rgba(37,99,235,0.15)] border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-500 transform hover:-translate-y-2">
                
                <div class="bg-blue-900 px-8 py-6 flex justify-between items-center text-white relative overflow-hidden border-b-4 border-blue-600">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-blue-800 z-0"></div>
                    <div class="relative z-10 w-full">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                <p class="text-blue-300 text-xs font-black uppercase tracking-widest mb-1">Status Nutrisi</p>
                                <h3 class="text-2xl font-black flex items-center gap-3">
                                    AKG MENU 
                                    @auth
                                        <button type="button" @click.stop="isEditOpen = true" class="bg-white/10 hover:bg-blue-600 px-3 py-1.5 rounded-sm text-[10px] font-black tracking-widest text-white transition-colors border border-white/20 hover:border-blue-500 flex items-center gap-1 shadow-lg cursor-pointer relative z-50">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            EDIT
                                        </button>
                                    @endauth
                                </h3>
                            </div>
                            <div class="text-right">
                                <p class="text-blue-400 text-[10px] uppercase tracking-widest font-bold">Diperbarui</p>
                                <p class="font-bold text-sm tracking-wide" x-text="formatTanggal(data.updated_at)"></p>
                            </div>
                        </div>
                        
                        <div class="flex gap-1 bg-black/30 p-1 rounded-md mt-2 relative z-50">
                            <button type="button" @click.stop="switchPorsi('Kecil')" :class="porsi === 'Kecil' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:text-white hover:bg-white/10'" class="flex-1 py-2 rounded-sm text-xs font-black uppercase tracking-wider transition-all cursor-pointer">Porsi Kecil</button>
                            <button type="button" @click.stop="switchPorsi('Besar')" :class="porsi === 'Besar' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:text-white hover:bg-white/10'" class="flex-1 py-2 rounded-sm text-xs font-black uppercase tracking-wider transition-all cursor-pointer">Porsi Besar</button>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 flex-grow flex flex-col justify-between bg-white relative">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3 text-center sm:text-left">* Ketuk kotak nutrisi untuk info detail</p>
                    <div :class="isAnimating ? 'opacity-0 scale-[0.98]' : 'opacity-100 scale-100'" class="transition-all duration-200 ease-out grid grid-cols-2 gap-3 mb-6 relative z-10">
                        <div @click="openInfo('energi')" class="bg-slate-50 rounded-lg p-4 border border-slate-100 hover:border-[#2563eb] hover:bg-blue-50 transition-all flex justify-between items-center cursor-pointer group active:scale-95">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:text-[#2563eb]">Energi</span>
                            <div class="text-lg font-black text-slate-900 group-hover:text-[#1e3a8a]"><span x-text="data.energi"></span> <span class="text-[10px] text-slate-400">kkal</span></div>
                        </div>
                        <div @click="openInfo('karbohidrat')" class="bg-slate-50 rounded-lg p-4 border border-slate-100 hover:border-[#2563eb] hover:bg-blue-50 transition-all flex justify-between items-center cursor-pointer group active:scale-95">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:text-[#2563eb]">Karb.</span>
                            <div class="text-lg font-black text-slate-900 group-hover:text-[#1e3a8a]"><span x-text="data.karbohidrat"></span> <span class="text-[10px] text-slate-400">g</span></div>
                        </div>
                        <div @click="openInfo('protein')" class="bg-slate-50 rounded-lg p-4 border border-slate-100 hover:border-[#2563eb] hover:bg-blue-50 transition-all flex justify-between items-center cursor-pointer group active:scale-95">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:text-[#2563eb]">Protein</span>
                            <div class="text-lg font-black text-slate-900 group-hover:text-[#1e3a8a]"><span x-text="data.protein"></span> <span class="text-[10px] text-slate-400">g</span></div>
                        </div>
                        <div @click="openInfo('lemak')" class="bg-slate-50 rounded-lg p-4 border border-slate-100 hover:border-[#2563eb] hover:bg-blue-50 transition-all flex justify-between items-center cursor-pointer group active:scale-95">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:text-[#2563eb]">Lemak</span>
                            <div class="text-lg font-black text-slate-900 group-hover:text-[#1e3a8a]"><span x-text="data.lemak"></span> <span class="text-[10px] text-slate-400">g</span></div>
                        </div>
                        <div @click="openInfo('serat')" class="bg-slate-50 rounded-lg p-4 border border-slate-100 hover:border-[#2563eb] hover:bg-blue-50 transition-all col-span-2 flex justify-between items-center cursor-pointer group active:scale-95">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 group-hover:text-[#2563eb]">Serat</span>
                            <div class="text-lg font-black text-slate-900 group-hover:text-[#1e3a8a]"><span x-text="data.serat"></span> <span class="text-[10px] text-slate-400">g</span></div>
                        </div>
                    </div>
                    <div :class="isAnimating ? 'opacity-0 translate-y-2' : 'opacity-100 translate-y-0'" class="transition-all duration-300 mt-auto bg-slate-50 border-l-4 border-blue-600 text-slate-900 rounded-r-lg p-5 flex items-center justify-between">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-600">Total Produksi</span>
                        <span class="text-3xl font-black text-[#2563eb]"><span x-text="data.total_produksi"></span> <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Porsi</span></span>
                    </div>
                </div>

                <!-- MODAL INFO NUTRISI -->
                <template x-teleport="body">
                    <div x-show="infoModalOpen" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                        <div x-show="infoModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="infoModalOpen = false"></div>
                        <div x-show="infoModalOpen" x-transition.scale class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden border-t-4 border-[#2563eb] text-center p-8">
                            <div class="w-16 h-16 bg-blue-50 text-[#2563eb] rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="font-black text-2xl text-slate-900 mb-2 uppercase tracking-wide" x-text="nutrientsInfo[activeNutrient].title"></h4>
                            <div class="bg-slate-50 py-3 px-4 rounded-xl inline-block mb-4 border border-slate-200 shadow-sm">
                                <span class="text-xs font-black text-slate-500 uppercase tracking-widest mr-2">Nilai Saat Ini:</span>
                                <span class="text-2xl font-black text-[#2563eb]"><span x-text="data[activeNutrient]"></span> <span class="text-sm text-slate-400" x-text="nutrientsInfo[activeNutrient].unit"></span></span>
                            </div>
                            <p class="text-slate-600 font-medium text-sm leading-relaxed mb-6" x-text="nutrientsInfo[activeNutrient].desc"></p>
                            <button @click="infoModalOpen = false" class="w-full bg-[#2563eb] text-white font-black uppercase tracking-widest py-3 rounded-xl hover:bg-blue-700 transition-colors shadow-md">Tutup Info</button>
                        </div>
                    </div>
                </template>

                <!-- MODAL EDIT AKG -->
                @auth
                <template x-teleport="body">
                    <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                        <div x-show="isEditOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="isEditOpen = false"></div>
                        <div x-show="isEditOpen" x-transition.scale class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto border-t-4 border-[#2563eb]">
                            <div class="bg-slate-50 px-6 py-5 flex justify-between items-center border-b border-slate-200">
                                <div><p class="text-[#2563eb] text-[10px] font-black uppercase tracking-widest mb-1">Control Panel</p><h3 class="font-black text-xl text-slate-900 uppercase tracking-wide">Update Nilai AKG</h3></div>
                                <button type="button" @click="isEditOpen = false" class="text-slate-400 hover:text-red-500 transition-colors bg-white border border-slate-200 p-2 rounded-md hover:bg-red-50"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>
                            <div class="flex bg-slate-100 p-2 gap-2 border-b border-slate-200">
                                <button type="button" @click="editTab = 'Kecil'" :class="editTab === 'Kecil' ? 'bg-[#2563eb] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-200'" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all">Porsi Kecil</button>
                                <button type="button" @click="editTab = 'Besar'" :class="editTab === 'Besar' ? 'bg-[#2563eb] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-200'" class="flex-1 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all">Porsi Besar</button>
                            </div>
                            <div class="p-6 md:p-8">
                                <form x-show="editTab === 'Kecil'" action="{{ route('akg.update', $akgKecil->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-8">
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Energi</label><input type="number" step="0.1" name="energi" value="{{ $akgKecil->energi }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Karbo</label><input type="number" step="0.1" name="karbohidrat" value="{{ $akgKecil->karbohidrat }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Protein</label><input type="number" step="0.1" name="protein" value="{{ $akgKecil->protein }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Lemak</label><input type="number" step="0.1" name="lemak" value="{{ $akgKecil->lemak }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Serat</label><input type="number" step="0.1" name="serat" value="{{ $akgKecil->serat }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-[#2563eb] uppercase tracking-widest block mb-2">Total Produksi</label><input type="number" name="total_produksi" value="{{ $akgKecil->total_produksi }}" class="w-full rounded-xl bg-blue-50 border-blue-200 text-blue-900 font-black py-3"></div>
                                    </div>
                                    <div class="mb-8 bg-slate-50 p-5 rounded-2xl border border-slate-200" x-data="{ opsiTanggal: 'server' }">
                                        <label class="text-[10px] font-black text-slate-500 block mb-3 uppercase tracking-widest">Pembaruan Tanggal</label>
                                        <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                            <label class="flex-1 cursor-pointer"><input type="radio" name="opsi_tanggal" value="server" x-model="opsiTanggal" class="peer sr-only"><div class="text-center py-3 rounded-xl border-2 text-xs font-black uppercase peer-checked:border-[#2563eb] peer-checked:bg-white peer-checked:text-[#2563eb]">Hari Ini</div></label>
                                            <label class="flex-1 cursor-pointer"><input type="radio" name="opsi_tanggal" value="manual" x-model="opsiTanggal" class="peer sr-only"><div class="text-center py-3 rounded-xl border-2 text-xs font-black uppercase peer-checked:border-[#2563eb] peer-checked:bg-white peer-checked:text-[#2563eb]">Manual</div></label>
                                        </div>
                                        <div x-show="opsiTanggal === 'manual'"><input type="date" name="tanggal_manual" class="w-full rounded-xl bg-white border-slate-300 font-bold shadow-sm py-3"></div>
                                    </div>
                                    <button type="submit" class="w-full bg-[#2563eb] text-white font-black uppercase tracking-widest py-4 rounded-xl hover:bg-blue-700 transition-all shadow-[0_4px_15px_rgba(37,99,235,0.4)]">Update Porsi Kecil</button>
                                </form>
                                <form x-show="editTab === 'Besar'" action="{{ route('akg.update', $akgBesar->id) }}" method="POST" style="display: none;">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-8">
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Energi</label><input type="number" step="0.1" name="energi" value="{{ $akgBesar->energi }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Karbo</label><input type="number" step="0.1" name="karbohidrat" value="{{ $akgBesar->karbohidrat }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Protein</label><input type="number" step="0.1" name="protein" value="{{ $akgBesar->protein }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Lemak</label><input type="number" step="0.1" name="lemak" value="{{ $akgBesar->lemak }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Serat</label><input type="number" step="0.1" name="serat" value="{{ $akgBesar->serat }}" class="w-full rounded-xl bg-slate-50 border-slate-200 focus:border-[#2563eb] font-bold py-3"></div>
                                        <div><label class="text-[10px] font-black text-[#2563eb] uppercase tracking-widest block mb-2">Total Produksi</label><input type="number" name="total_produksi" value="{{ $akgBesar->total_produksi }}" class="w-full rounded-xl bg-blue-50 border-blue-200 text-blue-900 font-black py-3"></div>
                                    </div>
                                    <div class="mb-8 bg-slate-50 p-5 rounded-2xl border border-slate-200" x-data="{ opsiTanggal: 'server' }">
                                        <label class="text-[10px] font-black text-slate-500 block mb-3 uppercase tracking-widest">Pembaruan Tanggal</label>
                                        <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                            <label class="flex-1 cursor-pointer"><input type="radio" name="opsi_tanggal" value="server" x-model="opsiTanggal" class="peer sr-only"><div class="text-center py-3 rounded-xl border-2 text-xs font-black uppercase peer-checked:border-[#2563eb] peer-checked:bg-white peer-checked:text-[#2563eb]">Hari Ini</div></label>
                                            <label class="flex-1 cursor-pointer"><input type="radio" name="opsi_tanggal" value="manual" x-model="opsiTanggal" class="peer sr-only"><div class="text-center py-3 rounded-xl border-2 text-xs font-black uppercase peer-checked:border-[#2563eb] peer-checked:bg-white peer-checked:text-[#2563eb]">Manual</div></label>
                                        </div>
                                        <div x-show="opsiTanggal === 'manual'"><input type="date" name="tanggal_manual" class="w-full rounded-xl bg-white border-slate-300 font-bold shadow-sm py-3"></div>
                                    </div>
                                    <button type="submit" class="w-full bg-[#2563eb] text-white font-black uppercase tracking-widest py-4 rounded-xl hover:bg-blue-700 transition-all shadow-[0_4px_15px_rgba(37,99,235,0.4)]">Update Porsi Besar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
                @endauth
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- SEKSI BGN PUSAT (CALL-TO-ACTION BUTTON SEDERHANA) -->
        <!-- ========================================================= -->
        <div data-aos="fade-up" class="mt-10 mb-16">
            <!-- Banner Tombol Utama Menggantikan Berita Grid -->
            <a href="{{ route('bgn.info') }}" class="block w-full bg-gradient-to-r from-[#0f172a] via-[#1e3a8a] to-[#2563eb] rounded-3xl p-8 sm:p-10 overflow-hidden shadow-xl group transition-all hover:shadow-[0_20px_50px_rgba(37,99,235,0.3)] hover:-translate-y-1 relative">
                
                <!-- Background pattern (Tetap Estetik) -->
                <div class="absolute inset-0 bg-blue-900/40 mix-blend-multiply group-hover:scale-105 transition-transform duration-700 z-0">
                    <div class="w-full h-full opacity-30" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
                </div>
                
                <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8">
                    <!-- Icon & Judul BGN -->
                    <div class="flex items-center gap-5 sm:gap-6 text-center sm:text-left flex-col sm:flex-row">
                        <!-- Icon Garuda/Dokumen -->
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white shrink-0 border border-white/20 group-hover:bg-white/20 transition-colors shadow-inner">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-red-400 group-hover:text-red-300 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 7v6.5c0 5.05 3.81 9.71 9 11.5 5.19-1.79 9-6.45 9-11.5V7l-9-5zm0 2.2l7 3.9v5.4c0 3.9-2.5 7.5-7 8.9-4.5-1.4-7-5-7-8.9V8.1l7-3.9zm-2 10.3l-3-3 1.4-1.4 1.6 1.6 4.6-4.6 1.4 1.4-6 6z"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center justify-center sm:justify-start gap-2 mb-2">
                                <span class="bg-red-500 text-white text-[9px] sm:text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded shadow-sm">INFO RESMI</span>
                                <span class="text-blue-200 text-[10px] font-bold uppercase tracking-widest">Badan Gizi Nasional (BGN)</span>
                            </div>
                            <h3 class="text-xl sm:text-3xl font-black text-white tracking-wide group-hover:text-blue-100 transition-colors leading-tight">
                                Akses Portal Informasi &<br class="hidden sm:block"> Regulasi Pedoman Gizi Pusat
                            </h3>
                        </div>
                    </div>
                    
                    <!-- Aksen Tombol Panah Kanan -->
                    <div class="w-full sm:w-auto shrink-0 flex items-center justify-center">
                        <span class="inline-flex items-center justify-center gap-3 bg-white text-[#2563eb] font-black text-xs sm:text-sm uppercase tracking-widest px-8 py-4 sm:py-5 rounded-xl group-hover:bg-blue-50 transition-colors shadow-[0_10px_25px_rgba(0,0,0,0.2)]">
                            KUNJUNGI PORTAL BGN 
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- INSTAGRAM FEED -->
        <div data-aos="fade-up" data-aos-duration="1000" class="group bg-white rounded-2xl shadow-xl hover:shadow-[0_20px_50px_rgba(37,99,235,0.15)] border border-gray-100 w-full overflow-hidden transition-all duration-500 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-blue-400 to-blue-800"></div>
            <div class="p-8 lg:p-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 rounded-xl flex shrink-0 items-center justify-center text-white shadow-lg">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs font-black uppercase tracking-widest mb-1">Sosial Media</p>
                            <h3 class="text-2xl font-black text-gray-900 leading-none">@sppg.magelangborobudur</h3>
                        </div>
                    </div>
                </div>
                <div class="w-full relative rounded-xl overflow-hidden bg-gray-50 border border-gray-100 min-h-[400px]">
                    <div class="sk-instagram-feed w-full" data-embed-id="25712216"></div>
                    <script src="https://widgets.sociablekit.com/instagram-feed/widget.js" defer></script>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Inisialisasi Animasi AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> document.addEventListener("DOMContentLoaded", function() { AOS.init({ once: true, offset: 50 }); }); </script>
</x-app-layout>
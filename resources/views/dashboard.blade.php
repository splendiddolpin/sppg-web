<x-app-layout>
    <!-- Memuat Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style> 
        body, html { background-color: #F8FAFC !important; overflow-x: hidden; scroll-behavior: smooth; } 
        .clip-diagonal { clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); }
        .modal-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .modal-scroll::-webkit-scrollbar-track { background: transparent; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body { padding-bottom: 80px; }
    </style>

    @if(session('success'))
        <div class="fixed top-24 right-4 sm:right-8 bg-white border-l-4 border-emerald-500 text-slate-800 px-6 py-4 shadow-[0_10px_40px_rgba(0,0,0,0.1)] font-bold flex items-center gap-3 z-[100] animate-bounce rounded-r-lg">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="relative bg-gradient-to-br from-[#0f172a] via-[#1e3a8a] to-[#2563eb] pt-24 sm:pt-32 pb-32 overflow-hidden clip-diagonal">
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-blue-500 opacity-20 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[30%] h-[30%] bg-white opacity-10 blur-[80px] rounded-full"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <span class="inline-block px-4 py-1.5 rounded-full border border-blue-400/30 text-blue-200 text-[10px] font-black uppercase tracking-[0.3em] mb-3 backdrop-blur-md">
                    Control Panel SPPG
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight mb-2 drop-shadow-lg">
                    Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">{{ Auth::user()->name }}</span> 👋
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-blue-200 font-medium tracking-wide">
                    Dashboard Analitik dan Manajemen Data SPPG Terpusat.
                </p>
            </div>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT DENGAN ALPINE.JS STATE -->
    <div x-data="dashboardApp()" class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-16 pb-20">
        
        <!-- BENTO GRID (SEKARANG BISA DIKLIK) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-8 sm:mb-10">
            <!-- Kartu 1: Total Saldo -->
            <div @click="openModal('saldo')" class="col-span-2 md:col-span-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-lg text-white relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <p class="text-emerald-200 font-black text-[10px] sm:text-xs uppercase tracking-widest mb-2">Total Saldo Kas</p>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight drop-shadow-sm">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center text-[9px] font-bold text-emerald-100 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                        <span>Lihat Rincian</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </div>
            
            <!-- Kartu 2: Pemasukan -->
            <div @click="openModal('pemasukan')" class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:border-green-300 hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer hover:-translate-y-1">
                <div>
                    <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-2 group-hover:text-green-500 transition-colors">Pemasukan</p>
                    <h3 class="text-lg sm:text-xl font-black text-green-500">+ Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-2 text-[9px] font-bold text-slate-300 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                    Detail <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
            
            <!-- Kartu 3: Pengeluaran (Dengan Rincian & Klik) -->
            <div @click="openModal('pengeluaran')" class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-sm border border-slate-100 hover:border-red-300 hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer hover:-translate-y-1 relative">
                <div>
                    <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-1 group-hover:text-red-500 transition-colors">Total Pengeluaran</p>
                    <h3 class="text-lg sm:text-xl font-black text-red-500 mb-2">- Rp {{ number_format($pengeluaran ?? 0, 0, ',', '.') }}</h3>
                </div>
                
                <!-- Rincian Singkat (Tampil di dalam Card) -->
                <div class="mt-1 pt-2 border-t border-slate-100/80 space-y-1">
                    <div class="flex justify-between items-center text-[9px] font-bold">
                        <span class="text-slate-400">Umum</span>
                        <span class="text-red-400">Rp {{ number_format($pengeluaranUmum ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[9px] font-bold">
                        <span class="text-purple-400">Mitra</span>
                        <span class="text-purple-500">Rp {{ number_format($reimburseMitra ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[9px] font-bold">
                        <span class="text-orange-400">Operasional</span>
                        <span class="text-orange-500">Rp {{ number_format($reimburseOperasional ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[9px] font-bold">
                        <span class="text-teal-400">Bahan Baku</span>
                        <span class="text-teal-500">Rp {{ number_format($reimburseCV ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-3 text-[8px] font-bold text-slate-300 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1 group-hover:text-red-400">
                    Klik Info Lengkap <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
            
            <!-- Kartu 4: Menu Aktif -->
            <div @click="openModal('menu')" class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer hover:-translate-y-1">
                <div>
                    <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-2 group-hover:text-[#2563eb] transition-colors">Menu Aktif</p>
                    <h3 class="text-2xl sm:text-3xl font-black text-[#2563eb]">{{ isset($menuItems) ? $menuItems->count() : 0 }} <span class="text-xs text-slate-400 uppercase tracking-widest">Item</span></h3>
                </div>
                <div class="mt-2 text-[9px] font-bold text-slate-300 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                    Detail Data <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </div>

        <!-- MANAJEMEN REQUEST MENU & ANALITIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-10">
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Manajemen Request</h3>
                </div>
                <div class="p-4 sm:p-6 flex-grow overflow-y-auto max-h-[500px] modal-scroll flex flex-col gap-3">
                    @if(isset($requests) && $requests->count() > 0)
                        @foreach($requests as $item)
                            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row justify-between gap-4 hover:border-blue-200 transition-colors group">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm {{ $item->status == 'Pending' ? 'bg-amber-100 text-amber-600' : ($item->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600') }}">
                                        @if($item->status == 'Pending')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @elseif($item->status == 'Disetujui')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded border {{ $item->status == 'Pending' ? 'bg-amber-50 text-amber-600 border-amber-200' : ($item->status == 'Disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-red-50 text-red-600 border-red-200') }}">
                                                {{ $item->status }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $item->created_at->format('d M Y - H:i') }}</span>
                                        </div>
                                        <h4 class="font-black text-sm text-slate-800 leading-snug">{{ $item->nama_menu }}</h4>
                                        <p class="text-[10px] sm:text-xs font-bold text-slate-500 mt-1 max-w-sm">{{ $item->deskripsi ?? 'Porsi Standar' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center sm:justify-end gap-2 border-t sm:border-t-0 border-slate-200 pt-3 sm:pt-0 mt-1 sm:mt-0 w-full sm:w-auto shrink-0">
                                    @if($item->status == 'Pending')
                                        <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST" class="flex-1 sm:flex-none">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-500 hover:text-white rounded-lg text-xs font-black uppercase tracking-widest transition-all">Setuju</button>
                                        </form>
                                        <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST" class="flex-1 sm:flex-none">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-red-50 text-red-600 border border-red-200 hover:bg-red-500 hover:text-white rounded-lg text-xs font-black uppercase tracking-widest transition-all">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-bold text-slate-400 italic">Selesai diulas</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                            <p class="text-xs font-bold uppercase tracking-widest">Belum ada request</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1 flex flex-col gap-6 sm:gap-8">
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4">Statistik Request</h3>
                    <div class="flex-1 relative w-full flex justify-center items-center min-h-[200px]">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4 flex items-center gap-2">Menu Terfavorit</h3>
                    <div class="space-y-3">
                        @if(isset($topMenus) && count($topMenus) > 0)
                            @foreach($topMenus as $menuName => $count)
                                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100 hover:border-blue-200 transition-colors">
                                    <span class="font-bold text-slate-700 text-xs sm:text-sm truncate pr-2">{{ $menuName }}</span>
                                    <span class="bg-[#eff6ff] text-[#2563eb] text-[10px] font-black uppercase px-2.5 py-1 rounded border border-[#bfdbfe] shrink-0">{{ $count }}x</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-xs text-center text-slate-400 font-bold py-4">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 3. MANAJEMEN MASTER MENU (CRUD) -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-10">
            <!-- Table Master Menu -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Master Menu</h3>
                </div>
                <div class="overflow-x-auto max-h-[400px] modal-scroll">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="sticky top-0 bg-slate-50/95 backdrop-blur-sm z-10 shadow-sm border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Menu</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($menuItems) && $menuItems->count() > 0)
                                @foreach($menuItems as $menu)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ $menu->nama }}</td>
                                        <td class="px-6 py-4"><span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest rounded bg-slate-100 text-slate-600 border border-slate-200">{{ $menu->kategori }}</span></td>
                                        <td class="px-6 py-4 text-xs font-black text-[#2563eb]">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('master-menu.edit', $menu->id) }}" class="p-2 bg-slate-50 rounded-lg text-slate-400 hover:text-[#2563eb] hover:bg-blue-50 transition-colors tooltip" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <!-- TOMBOL DELETE BARU (Memanggil Modal Alpine) -->
                                                <button type="button" @click="confirmDelete('{{ route('master-menu.destroy', $menu->id) }}', '{{ addslashes($menu->nama) }}')" class="p-2 bg-slate-50 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors tooltip" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">Katalog Kosong</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah Menu -->
            <div class="lg:col-span-1 bg-gradient-to-br from-[#1e3a8a] to-[#2563eb] rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden flex flex-col justify-center">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                <h3 class="font-black text-sm uppercase tracking-widest mb-6 relative z-10">Tambah Master Menu</h3>
                <form action="{{ route('master-menu.store') }}" method="POST" class="relative z-10 space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-blue-200 uppercase tracking-widest">Nama Menu</label>
                        <input type="text" name="nama" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-blue-400/30 text-white placeholder-blue-300 focus:ring-2 focus:ring-white focus:border-transparent px-4 py-3 text-xs font-bold" placeholder="Cth: Ayam Bakar">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-blue-200 uppercase tracking-widest">Kategori</label>
                            <select name="kategori" required class="w-full mt-1.5 rounded-xl bg-blue-800 border border-blue-400/30 text-white focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold">
                                <option value="Karbohidrat">Karbohidrat</option>
                                <option value="Protein Hewani">Hewani</option>
                                <option value="Protein Nabati">Nabati</option>
                                <option value="Sayur">Sayur</option>
                                <option value="Buah">Buah</option>
                                <option value="Susu">Susu</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-blue-200 uppercase tracking-widest">Harga (Rp)</label>
                            <input type="number" name="harga" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-blue-400/30 text-white placeholder-blue-300 focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold" placeholder="2000">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-white text-[#2563eb] font-black uppercase tracking-widest py-3.5 rounded-xl hover:bg-blue-50 transition-colors shadow-[0_5px_15px_rgba(0,0,0,0.2)] mt-4 text-xs">Simpan Menu</button>
                </form>
            </div>
        </div>

       <!-- ========================================== -->
        <!-- 4. MANAJEMEN KAS & REIMBURSE (CRUD) -->
        <!-- ========================================== -->
        <div id="riwayat-kas" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-10">
            <!-- Tabel Riwayat Keuangan (Dengan Filter Kategori & Pagination) -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden flex flex-col h-full">
                
                <!-- Header & Tab Filter Kategori -->
                <div class="px-6 py-5 border-b border-slate-100 flex flex-col gap-4 bg-slate-50/50">
                    <div class="flex justify-between items-center">
                        <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Riwayat Keuangan & Reimburse</h3>
                        @if(method_exists($kasItems, 'total'))
                            <span class="text-[10px] font-bold text-slate-400">Total: {{ $kasItems->total() }} Data</span>
                        @endif
                    </div>

                    <!-- Pill Filter Kategori -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        @php $kat = $kategoriKas ?? request('kategori_kas', ''); @endphp
                        <a href="{{ route('dashboard', ['kategori_kas' => '']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === '' ? 'bg-slate-800 text-white border-slate-800 shadow-sm' : 'bg-white text-slate-500 border-slate-200 hover:bg-slate-100' }}">
                            Semua
                        </a>
                        <a href="{{ route('dashboard', ['kategori_kas' => 'Pemasukan']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === 'Pemasukan' ? 'bg-green-600 text-white border-green-600 shadow-sm' : 'bg-green-50/60 text-green-600 border-green-200 hover:bg-green-100' }}">
                            Pemasukan
                        </a>
                        <a href="{{ route('dashboard', ['kategori_kas' => 'Pengeluaran Umum']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === 'Pengeluaran Umum' ? 'bg-red-600 text-white border-red-600 shadow-sm' : 'bg-red-50/60 text-red-600 border-red-200 hover:bg-red-100' }}">
                            Umum
                        </a>
                        <a href="{{ route('dashboard', ['kategori_kas' => 'Reimburse Mitra']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === 'Reimburse Mitra' ? 'bg-purple-600 text-white border-purple-600 shadow-sm' : 'bg-purple-50/60 text-purple-600 border-purple-200 hover:bg-purple-100' }}">
                            Mitra
                        </a>
                        <a href="{{ route('dashboard', ['kategori_kas' => 'Reimburse Operasional']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === 'Reimburse Operasional' ? 'bg-orange-500 text-white border-orange-500 shadow-sm' : 'bg-orange-50/60 text-orange-600 border-orange-200 hover:bg-orange-100' }}">
                            Operasional
                        </a>
                        <a href="{{ route('dashboard', ['kategori_kas' => 'Reimburse CV (Bahan Baku)']) }}#riwayat-kas" 
                           class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all border {{ $kat === 'Reimburse CV (Bahan Baku)' ? 'bg-teal-600 text-white border-teal-600 shadow-sm' : 'bg-teal-50/60 text-teal-600 border-teal-200 hover:bg-teal-100' }}">
                            CV (Bahan Baku)
                        </a>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto max-h-[420px] modal-scroll flex-grow">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="sticky top-0 bg-slate-50/95 backdrop-blur-sm z-10 shadow-sm border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan & Jenis</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($kasItems) && $kasItems->count() > 0)
                                @foreach($kasItems as $kas)
                                    @php
                                        // Logika untuk menentukan warna badge berdasarkan jenis transaksi
                                        $isExpense = $kas->jenis != 'Pemasukan';
                                        
                                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200'; // Default
                                        if ($kas->jenis == 'Pemasukan') {
                                            $badgeClass = 'bg-green-50 text-green-600 border-green-200';
                                        } elseif ($kas->jenis == 'Pengeluaran Umum' || $kas->jenis == 'Pengeluaran') {
                                            $badgeClass = 'bg-red-50 text-red-600 border-red-200';
                                        } elseif ($kas->jenis == 'Reimburse Mitra') {
                                            $badgeClass = 'bg-purple-50 text-purple-600 border-purple-200';
                                        } elseif ($kas->jenis == 'Reimburse Operasional') {
                                            $badgeClass = 'bg-orange-50 text-orange-600 border-orange-200';
                                        } elseif ($kas->jenis == 'Reimburse CV (Bahan Baku)') {
                                            $badgeClass = 'bg-teal-50 text-teal-600 border-teal-200';
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($kas->tanggal)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-slate-800">{{ $kas->keterangan }}</div>
                                            <!-- Badge Warna Warni Dinamis -->
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded mt-1.5 inline-block border {{ $badgeClass }}">
                                                {{ $kas->jenis }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-black {{ $isExpense ? 'text-red-500' : 'text-green-500' }}">
                                            {{ $isExpense ? '-' : '+' }} Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Logika Khusus Reimburse -->
                                                @if(str_contains($kas->jenis, 'Reimburse'))
                                                    @if(empty($kas->status) || $kas->status == 'Pending')
                                                        <!-- Tombol Centang Pelunasan -->
                                                        <button type="button" @click="confirmLunas('{{ route('kas.lunas', $kas->id) }}', '{{ addslashes($kas->keterangan) }}', '{{ number_format($kas->nominal, 0, ',', '.') }}')" class="p-2 bg-slate-50 rounded-lg text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 transition-colors tooltip" title="Lunasi Reimburse">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    @else
                                                        <!-- Badge Lunas (Jika sudah dicentang) -->
                                                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded text-[9px] font-black uppercase tracking-widest cursor-default" title="Sudah Dicairkan">Lunas</span>
                                                    @endif
                                                @endif
                                                
                                                <!-- Tombol Hapus -->
                                                <button type="button" @click="confirmDelete('{{ route('kas.destroy', $kas->id) }}', 'Transaksi: {{ addslashes($kas->keterangan) }}')" class="p-2 bg-slate-50 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors tooltip" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">Belum ada catatan keuangan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                @if(method_exists($kasItems, 'hasPages') && $kasItems->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Halaman {{ $kasItems->currentPage() }} dari {{ $kasItems->lastPage() }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            @if($kasItems->onFirstPage())
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">Sebelumnya</span>
                            @else
                                <a href="{{ $kasItems->previousPageUrl() }}#riwayat-kas" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-800 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors shadow-sm">Sebelumnya</a>
                            @endif

                            @if($kasItems->hasMorePages())
                                <a href="{{ $kasItems->nextPageUrl() }}#riwayat-kas" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-800 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors shadow-sm">Selanjutnya</a>
                            @else
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">Selanjutnya</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Tambah Kas & Reimburse -->
            <div class="lg:col-span-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden flex flex-col justify-center">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                <h3 class="font-black text-sm uppercase tracking-widest mb-6 relative z-10">Catat Transaksi</h3>
                <form action="{{ route('kas.store') }}" method="POST" class="relative z-10 space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-emerald-400/30 text-white focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold">
                    </div>
                    
                    <!-- Dropdown Kategori Kas / Reimburse Baru -->
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Jenis Transaksi</label>
                        <select name="jenis" required class="w-full mt-1.5 rounded-xl bg-emerald-800 border border-emerald-400/30 text-white focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold">
                            <optgroup label="Pemasukan" class="bg-white text-slate-800">
                                <option value="Pemasukan">Pemasukan (Dana Masuk)</option>
                            </optgroup>
                            <optgroup label="Pengeluaran & Reimburse" class="bg-white text-slate-800">
                                <option value="Pengeluaran Umum">Pengeluaran Umum</option>
                                <option value="Reimburse Mitra">Reimburse Mitra</option>
                                <option value="Reimburse Operasional">Reimburse Operasional</option>
                                <option value="Reimburse CV (Bahan Baku)">Reimburse CV (Bahan Baku)</option>
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Keterangan / Tujuan</label>
                        <input type="text" name="keterangan" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-emerald-400/30 text-white placeholder-emerald-300 focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold" placeholder="Cth: Beli Ayam / Bensin">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Nominal (Rp)</label>
                        <input type="number" name="nominal" min="1" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-emerald-400/30 text-white placeholder-emerald-300 focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold" placeholder="50000">
                    </div>
                    <button type="submit" class="w-full bg-white text-emerald-700 font-black uppercase tracking-widest py-3.5 rounded-xl hover:bg-slate-50 transition-colors shadow-[0_5px_15px_rgba(0,0,0,0.2)] mt-4 text-xs">Simpan Transaksi</button>
                </form>
            </div>
        </div>
        <!-- ========================================== -->
        <!-- MODAL ALPINE GLOBAL UNTUK SEMUA DATA -->
        <!-- ========================================== -->
        <template x-teleport="body">
            <div> <!-- Pembungkus elemen teleport -->
                
                <!-- MODAL HAPUS DATA -->
                <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                    <!-- Latar Belakang Buram -->
                    <div x-show="showDeleteModal" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                    
                    <!-- Konten Modal -->
                    <div x-show="showDeleteModal" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                        class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 border-t-4 border-red-500 overflow-hidden text-center">
                        
                        <!-- Ikon Merah -->
                        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-red-100">
                            <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        
                        <h2 class="text-xl font-black text-slate-900 mb-2 uppercase tracking-wide">Konfirmasi Hapus</h2>
                        <p class="text-xs font-bold text-slate-500 mb-8 leading-relaxed">
                            Anda yakin ingin menghapus <span class="text-red-500 font-black" x-text="deleteItemName"></span> secara permanen? Data yang dihapus tidak dapat dikembalikan.
                        </p>

                        <div class="flex justify-center gap-3">
                            <button type="button" @click="showDeleteModal = false" class="w-full px-5 py-3.5 rounded-xl bg-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-colors">Batal</button>
                            <form :action="deleteUrl" method="POST" class="w-full m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full px-5 py-3.5 rounded-xl bg-red-600 text-white font-black text-[10px] uppercase tracking-widest shadow-[0_5px_15px_rgba(220,38,38,0.3)] hover:bg-red-700 hover:scale-105 transition-all">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- MODAL INFORMASI KARTU KAS (SEKARANG ADA DI DALAM TELEPORT) -->
                <div x-show="activeModal !== null" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                    <div x-show="activeModal !== null" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="closeModal()"></div>
                    
                    <div x-show="activeModal !== null" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                        class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 sm:p-8 overflow-hidden">
                        
                        <button @click="closeModal()" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-full transition-colors tooltip" title="Tutup">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>

                        <!-- 1. Detail Saldo -->
                        <template x-if="activeModal === 'saldo'">
                            <div>
                                <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Informasi Saldo</h2>
                                <p class="text-xs font-bold text-slate-500 mb-5">Akumulasi seluruh arus kas SPPG.</p>
                                <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 text-center">
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Saldo Tersedia</p>
                                    <h3 class="text-3xl font-black text-emerald-700 shadow-sm">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </template>

                        <!-- 2. Detail Pemasukan -->
                        <template x-if="activeModal === 'pemasukan'">
                            <div>
                                <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Total Pemasukan</h2>
                                <p class="text-xs font-bold text-slate-500 mb-5">Seluruh dana masuk yang tercatat di sistem.</p>
                                <div class="bg-green-50 rounded-2xl p-5 border border-green-100 text-center">
                                    <h3 class="text-2xl font-black text-green-600">+ Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </template>

                        <!-- 3. Detail Pengeluaran & Reimburse -->
                        <template x-if="activeModal === 'pengeluaran'">
                            <div>
                                <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4 border border-red-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                                </div>
                                <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Rincian Pengeluaran</h2>
                                <p class="text-xs font-bold text-slate-500 mb-5">Total keseluruhan: <span class="font-black text-red-500">Rp {{ number_format($pengeluaran ?? 0, 0, ',', '.') }}</span></p>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-600">Umum</span>
                                        <span class="text-xs font-black text-red-500">Rp {{ number_format($pengeluaranUmum ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3.5 bg-purple-50 rounded-xl border border-purple-100">
                                        <span class="text-[11px] font-black uppercase tracking-widest text-purple-700">Mitra</span>
                                        <span class="text-xs font-black text-purple-700">Rp {{ number_format($reimburseMitra ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3.5 bg-orange-50 rounded-xl border border-orange-100">
                                        <span class="text-[11px] font-black uppercase tracking-widest text-orange-700">Operasional</span>
                                        <span class="text-xs font-black text-orange-700">Rp {{ number_format($reimburseOperasional ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3.5 bg-teal-50 rounded-xl border border-teal-100">
                                        <span class="text-[11px] font-black uppercase tracking-widest text-teal-700">Bahan Baku</span>
                                        <span class="text-xs font-black text-teal-700">Rp {{ number_format($reimburseCV ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- 4. Detail Menu Aktif -->
                        <template x-if="activeModal === 'menu'">
                            <div>
                                <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Katalog Menu</h2>
                                <p class="text-xs font-bold text-slate-500 mb-5">Informasi master data menu SPPG.</p>
                                <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 text-center">
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Total Tersimpan</p>
                                    <h3 class="text-4xl font-black text-[#2563eb]">{{ isset($menuItems) ? $menuItems->count() : 0 }}</h3>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- MODAL PELUNASAN REIMBURSE -->
                <div x-show="showLunasModal" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                    <div x-show="showLunasModal" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="showLunasModal = false"></div>
                    
                    <div x-show="showLunasModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                         class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 border-t-4 border-emerald-500 overflow-hidden text-center">
                         
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-emerald-100">
                            <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        
                        <h2 class="text-xl font-black text-slate-900 mb-1 uppercase tracking-wide">Pencairan Dana</h2>
                        <p class="text-xs font-bold text-slate-500 mb-5 leading-relaxed">
                            Tandai reimburse <span class="text-emerald-600 font-black" x-text="lunasItemName"></span> sebagai lunas?
                        </p>
                        
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-6">
                            <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-1">Nominal yang dicairkan</p>
                            <h3 class="text-2xl font-black text-slate-800">Rp <span x-text="lunasAmount"></span></h3>
                        </div>

                        <div class="flex justify-center gap-3">
                            <button type="button" @click="showLunasModal = false" class="w-full px-5 py-3.5 rounded-xl bg-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-colors">Batal</button>
                            <form :action="lunasUrl" method="POST" class="w-full m-0">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full px-5 py-3.5 rounded-xl bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest shadow-[0_5px_15px_rgba(16,185,129,0.3)] hover:bg-emerald-600 hover:scale-105 transition-all">Ya, Lunasi</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div> <!-- PENUTUP UTAMA x-data="dashboardApp()" -->

    <!-- MODAL INFORMASI KARTU KAS (MUNCUL SAAT KARTU DIKLIK) -->
            <div x-show="activeModal !== null" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
                <div x-show="activeModal !== null" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="closeModal()"></div>
                
                <div x-show="activeModal !== null" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                     class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 sm:p-8 overflow-hidden">
                     
                     <button @click="closeModal()" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-full transition-colors tooltip" title="Tutup">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                     </button>

                     <!-- 1. Detail Saldo -->
                     <template x-if="activeModal === 'saldo'">
                         <div>
                             <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Informasi Saldo</h2>
                             <p class="text-xs font-bold text-slate-500 mb-5">Akumulasi seluruh arus kas SPPG.</p>
                             <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 text-center">
                                 <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Saldo Tersedia</p>
                                 <h3 class="text-3xl font-black text-emerald-700 shadow-sm">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</h3>
                             </div>
                         </div>
                     </template>

                     <!-- 2. Detail Pemasukan -->
                     <template x-if="activeModal === 'pemasukan'">
                         <div>
                             <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Total Pemasukan</h2>
                             <p class="text-xs font-bold text-slate-500 mb-5">Seluruh dana masuk yang tercatat di sistem.</p>
                             <div class="bg-green-50 rounded-2xl p-5 border border-green-100 text-center">
                                 <h3 class="text-2xl font-black text-green-600">+ Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</h3>
                             </div>
                         </div>
                     </template>

                     <!-- 3. Detail Pengeluaran & Reimburse (YANG PALING PENTING) -->
                     <template x-if="activeModal === 'pengeluaran'">
                         <div>
                             <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4 border border-red-100">
                                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                             </div>
                             <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Rincian Pengeluaran</h2>
                             <p class="text-xs font-bold text-slate-500 mb-5">Total keseluruhan: <span class="font-black text-red-500">Rp {{ number_format($pengeluaran ?? 0, 0, ',', '.') }}</span></p>
                             
                             <div class="space-y-3">
                                <div class="flex justify-between items-center p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-600">Umum</span>
                                    <span class="text-xs font-black text-red-500">Rp {{ number_format($pengeluaranUmum ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3.5 bg-purple-50 rounded-xl border border-purple-100">
                                    <span class="text-[11px] font-black uppercase tracking-widest text-purple-700">Mitra</span>
                                    <span class="text-xs font-black text-purple-700">Rp {{ number_format($reimburseMitra ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3.5 bg-orange-50 rounded-xl border border-orange-100">
                                    <span class="text-[11px] font-black uppercase tracking-widest text-orange-700">Operasional</span>
                                    <span class="text-xs font-black text-orange-700">Rp {{ number_format($reimburseOperasional ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3.5 bg-teal-50 rounded-xl border border-teal-100">
                                    <span class="text-[11px] font-black uppercase tracking-widest text-teal-700">Bahan Baku</span>
                                    <span class="text-xs font-black text-teal-700">Rp {{ number_format($reimburseCV ?? 0, 0, ',', '.') }}</span>
                                </div>
                             </div>
                         </div>
                     </template>

                     <!-- 4. Detail Menu Aktif -->
                     <template x-if="activeModal === 'menu'">
                         <div>
                             <h2 class="text-lg font-black text-slate-900 mb-1 uppercase tracking-wide">Katalog Menu</h2>
                             <p class="text-xs font-bold text-slate-500 mb-5">Informasi master data menu SPPG.</p>
                             <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 text-center">
                                 <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Total Tersimpan</p>
                                 <h3 class="text-4xl font-black text-[#2563eb]">{{ isset($menuItems) ? $menuItems->count() : 0 }}</h3>
                             </div>
                         </div>
                     </template>
                     
                </div>
            </div>

    <!-- SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            try {
                const ctx = document.getElementById('statusChart').getContext('2d');
                const dataPending = {{ $pending ?? 0 }};
                const dataDisetujui = {{ $disetujui ?? 0 }};
                const dataDitolak = {{ $ditolak ?? 0 }};
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Disetujui', 'Ditolak'],
                        datasets: [{
                            data: [dataPending, dataDisetujui, dataDitolak],
                            backgroundColor: ['#FBBF24', '#10B981', '#EF4444'],
                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { font: { family: 'inherit', weight: 'bold', size: 10 }, padding: 20, usePointStyle: true } } },
                        cutout: '75%'
                    }
                });
            } catch (error) { console.error("Chart Error:", error); }
        });

        // FUNGSI ALPINE UNTUK LOGIKA GLOBAL DASHBOARD
        // FUNGSI ALPINE UNTUK LOGIKA GLOBAL DASHBOARD
        function dashboardApp() {
            return {
                showDeleteModal: false,
                deleteUrl: '',
                deleteItemName: '',
                
                // Variabel khusus Modal Pelunasan Reimburse
                showLunasModal: false,
                lunasUrl: '',
                lunasItemName: '',
                lunasAmount: '',
                
                activeModal: null, 
                
                confirmDelete(url, itemName) {
                    this.deleteUrl = url;
                    this.deleteItemName = itemName;
                    this.showDeleteModal = true;
                },

                // Fungsi pemicu klik tombol centang
                confirmLunas(url, itemName, amount) {
                    this.lunasUrl = url;
                    this.lunasItemName = itemName;
                    this.lunasAmount = amount;
                    this.showLunasModal = true;
                },

                openModal(type) {
                    this.activeModal = type;
                },
                closeModal() {
                    this.activeModal = null;
                }
            }
        }

        function prosesScanAI(event) {
    const file = event.target.files[0];
    if (!file) return;

    // 1. Ubah teks tombol menjadi status loading
    const button = event.target.nextElementSibling;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> AI Sedang Membaca...';
    button.disabled = true;

    // 2. Siapkan data gambar untuk dikirim ke Laravel (Backend)
    const formData = new FormData();
    formData.append('image', file);
    
    // Ambil CSRF Token dari tag meta Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 3. Kirim ke Endpoint AIController
    fetch('{{ route("api.scan-akg") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            // 4. INJEKSI FORM: Masukkan angka dari AI langsung ke kotak input HTML Anda!
            // Ganti '#input-energi' dengan ID input form Anda yang sebenarnya
            if(document.getElementById('input-energi')) document.getElementById('input-energi').value = data.energi;
            if(document.getElementById('input-karbohidrat')) document.getElementById('input-karbohidrat').value = data.karbohidrat;
            if(document.getElementById('input-protein')) document.getElementById('input-protein').value = data.protein;
            if(document.getElementById('input-lemak')) document.getElementById('input-lemak').value = data.lemak;
            if(document.getElementById('input-serat')) document.getElementById('input-serat').value = data.serat;
            
            alert('Sukses! AI berhasil membaca dan mengisi nilai gizi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan jaringan saat menghubungi AI.');
    })
    .finally(() => {
        // Kembalikan tombol seperti semula
        button.innerHTML = originalText;
        button.disabled = false;
        event.target.value = ''; // Reset file input
    });
}
    </script>
</x-app-layout>
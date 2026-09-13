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
        
        <!-- BENTO GRID -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-8 sm:mb-10">
            <div class="col-span-2 md:col-span-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-lg text-white relative overflow-hidden group hover:-translate-y-1 transition-transform">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <p class="text-emerald-200 font-black text-[10px] sm:text-xs uppercase tracking-widest mb-2">Total Saldo Kas</p>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight drop-shadow-sm">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:border-green-300 transition-colors flex flex-col justify-between">
                <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-2">Pemasukan</p>
                <h3 class="text-lg sm:text-xl font-black text-green-500">+ Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:border-red-300 transition-colors flex flex-col justify-between">
                <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-2">Pengeluaran</p>
                <h3 class="text-lg sm:text-xl font-black text-red-500">- Rp {{ number_format($pengeluaran ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:border-blue-300 transition-colors flex flex-col justify-between">
                <p class="text-slate-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest mb-2">Menu Aktif</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[#2563eb]">{{ isset($menuItems) ? $menuItems->count() : 0 }} <span class="text-xs text-slate-400 uppercase tracking-widest">Item</span></h3>
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
        <!-- 4. MANAJEMEN KAS (CRUD) -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Riwayat Keuangan</h3>
                </div>
                <div class="overflow-x-auto max-h-[400px] modal-scroll">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="sticky top-0 bg-slate-50/95 backdrop-blur-sm z-10 shadow-sm border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($kasItems) && $kasItems->count() > 0)
                                @foreach($kasItems as $kas)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($kas->tanggal)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-slate-800">{{ $kas->keterangan }}</div>
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded mt-1 inline-block border {{ $kas->jenis == 'Pemasukan' ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                                                {{ $kas->jenis }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-black {{ $kas->jenis == 'Pemasukan' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $kas->jenis == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <!-- TOMBOL DELETE BARU UNTUK KAS -->
                                            <button type="button" @click="confirmDelete('{{ route('kas.destroy', $kas->id) }}', 'Catatan Kas: {{ addslashes($kas->keterangan) }}')" class="p-2 bg-slate-50 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">Belum ada catatan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah Kas -->
            <div class="lg:col-span-1 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden flex flex-col justify-center">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                <h3 class="font-black text-sm uppercase tracking-widest mb-6 relative z-10">Catat Transaksi</h3>
                <form action="{{ route('kas.store') }}" method="POST" class="relative z-10 space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-emerald-400/30 text-white focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Jenis Transaksi</label>
                        <select name="jenis" required class="w-full mt-1.5 rounded-xl bg-emerald-800 border border-emerald-400/30 text-white focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold">
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Keterangan</label>
                        <input type="text" name="keterangan" required class="w-full mt-1.5 rounded-xl bg-white/10 border border-emerald-400/30 text-white placeholder-emerald-300 focus:ring-2 focus:ring-white px-4 py-3 text-xs font-bold" placeholder="Cth: Dana BOS / Beli Gas">
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
        <!-- MODAL ALPINE GLOBAL UNTUK HAPUS DATA -->
        <!-- ========================================== -->
        <template x-teleport="body">
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
        </template>
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
        function dashboardApp() {
            return {
                showDeleteModal: false,
                deleteUrl: '',
                deleteItemName: '',
                
                // Fungsi untuk memicu modal hapus dari tombol mana saja
                confirmDelete(url, itemName) {
                    this.deleteUrl = url;
                    this.deleteItemName = itemName;
                    this.showDeleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>
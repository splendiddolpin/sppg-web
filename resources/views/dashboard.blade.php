<x-app-layout>
    <!-- Memuat Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-10 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Sapaan -->
            <div class="mb-8">
                <h2 class="font-black text-3xl text-gray-900 tracking-tight">
                    Halo, <span class="text-blue-600">{{ Auth::user()->name }}</span> 👋
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Dashboard Analitik dan Manajemen Data SPPG.</p>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Grid Atas: Grafik, Top Menu, & Tambah Menu -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- Kolom 1: Grafik -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col">
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Statistik Request</h3>
                    <div class="flex-1 relative w-full flex justify-center items-center min-h-[200px]">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Kolom 2: Menu Terfavorit -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <h3 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.66 11.2c-.23-.3-.51-.56-.77-.82-.67-.6-1.43-1.03-2.07-1.66C13.33 7.26 13 4.85 13.95 3c-.95.23-1.78.75-2.49 1.32-2.59 2.08-3.61 5.75-2.39 8.9.04.1.08.2.08.33 0 .22-.15.42-.35.5-.22.1-.46.04-.64-.12-.11-.1-.23-.21-.34-.32-1.14-1.09-1.88-2.61-1.67-4.23C4.05 11.26 3 14.12 3.63 17.05 4.14 19.46 5.8 21.46 8.08 22.42c2.6 1.1 5.67.62 7.78-1.28 2.22-2.01 2.94-5.26 1.8-8.2z"/></svg>
                        Menu Paling Laris
                    </h3>
                    
                    <div class="space-y-3">
                        @forelse($topMenus as $menuName => $count)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-blue-50/50 hover:border-blue-100 transition-colors">
                                <span class="font-bold text-gray-800 text-sm truncate pr-2">{{ $menuName }}</span>
                                <span class="bg-blue-100 text-blue-700 text-xs font-black px-2.5 py-1 rounded-md shadow-sm shrink-0">
                                    {{ $count }} Request
                                </span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="text-sm font-semibold">Belum ada data masuk</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Kolom 3: Form Tambah Menu -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 shadow-lg text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                    
                    <div>
                        <h3 class="font-bold text-lg mb-4 relative z-10">Tambah Master Menu</h3>
                        <form action="{{ route('master-menu.store') }}" method="POST" class="relative z-10 space-y-4">
                            @csrf
                            <div>
                                <label class="text-xs font-semibold text-blue-200">Nama Menu</label>
                                <input type="text" name="nama" required class="w-full mt-1 rounded-xl bg-white/10 border border-blue-400/30 text-white placeholder-blue-300 focus:ring-2 focus:ring-white focus:border-transparent px-4 py-2" placeholder="Cth: Ayam Bakar">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-blue-200">Kategori</label>
                                    <select name="kategori" required class="w-full mt-1 rounded-xl bg-blue-700/50 border border-blue-400/30 text-white focus:ring-2 focus:ring-white px-4 py-2 [&>option]:text-gray-900">
                                        <option value="Karbohidrat">Karbohidrat</option>
                                        <option value="Protein Hewani">Hewani</option>
                                        <option value="Protein Nabati">Nabati</option>
                                        <option value="Sayur">Sayur</option>
                                        <option value="Buah">Buah</option>
                                        <option value="Susu">Susu</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-blue-200">Harga (Rp)</label>
                                    <input type="number" name="harga" required class="w-full mt-1 rounded-xl bg-white/10 border border-blue-400/30 text-white placeholder-blue-300 focus:ring-2 focus:ring-white px-4 py-2" placeholder="2000">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-white text-blue-700 font-bold py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow-md mt-2">
                                Simpan Menu
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TABEL 1: MANAJEMEN REQUEST MENU (Setuju/Tolak) -->
            <!-- ========================================== -->
            <div class="mb-8 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-white">
                    <h3 class="font-bold text-lg text-gray-900">Manajemen Request Menu</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Tanggal</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Menu Diminta</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Deskripsi / Porsi</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Status</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($requests as $item)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->created_at->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-400 block">{{ $item->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-gray-900 leading-relaxed max-w-xs">{{ $item->nama_menu }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-medium text-gray-500">{{ $item->deskripsi ?? '-' }}</div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        @if($item->status == 'Pending')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        @elseif($item->status == 'Disetujui')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700">Disetujui</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="p-2 rounded-lg text-green-600 hover:bg-green-50 transition-colors tooltip" title="Setujui">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors tooltip" title="Tolak">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-400">Belum ada request.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TABEL 2: MANAJEMEN MASTER MENU (CRUD) -->
            <!-- ========================================== -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="font-bold text-lg text-gray-900">Manajemen Master Menu</h3>
                    <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">{{ $menuItems->count() }} Item Aktif</span>
                </div>
                
                <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                    <table class="w-full text-left border-collapse relative">
                        <thead class="sticky top-0 bg-gray-50/95 backdrop-blur-sm z-10 shadow-sm">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Nama Menu</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Kategori</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Harga</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($menuItems as $menu)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $menu->nama }}</div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                            {{ $menu->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4">
                                        <div class="text-sm font-black text-blue-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('master-menu.edit', $menu->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors tooltip" title="Edit Menu">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('master-menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors tooltip" title="Hapus Menu">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-8 text-center text-gray-400 text-sm font-bold">Belum ada menu yang didaftarkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- MODUL 3: MANAJEMEN KAS SPPG (CRUD) -->
            <!-- ========================================== -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                
                <!-- Kolom Kiri: Tabel Riwayat Kas -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                        <h3 class="font-bold text-lg text-gray-900">Manajemen Kas Keuangan</h3>
                    </div>
                    
                    <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                        <table class="w-full text-left border-collapse relative">
                            <thead class="sticky top-0 bg-gray-50/95 backdrop-blur-sm z-10 shadow-sm">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">Keterangan</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">Nominal</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($kasItems as $kas)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($kas->tanggal)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $kas->keterangan }}</div>
                                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md mt-1 inline-block {{ $kas->jenis == 'Pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $kas->jenis }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black {{ $kas->jenis == 'Pemasukan' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $kas->jenis == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('kas.destroy', $kas->id) }}" method="POST" onsubmit="return confirm('Hapus catatan kas ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors tooltip" title="Hapus Kas">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm font-bold">Belum ada catatan keuangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Tambah Kas (Tema Hijau/Emerald agar beda dengan menu) -->
                <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 shadow-lg text-white relative overflow-hidden h-fit">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
                    
                    <h3 class="font-bold text-lg mb-4 relative z-10">Catat Transaksi Baru</h3>
                    
                    <form action="{{ route('kas.store') }}" method="POST" class="relative z-10 space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-semibold text-emerald-200">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full mt-1 rounded-xl bg-white/10 border border-emerald-400/30 text-white focus:ring-2 focus:ring-white px-4 py-2 [color-scheme:dark]">
                        </div>
                        
                        <div>
                            <label class="text-xs font-semibold text-emerald-200">Jenis Transaksi</label>
                            <div class="mt-1 flex bg-white/10 p-1 rounded-xl border border-emerald-400/30 gap-1">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis" value="Pemasukan" class="peer sr-only" checked>
                                    <div class="text-center py-2 text-sm font-bold rounded-lg transition-all peer-checked:bg-white peer-checked:text-emerald-700 text-emerald-100 hover:text-white">Pemasukan</div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis" value="Pengeluaran" class="peer sr-only">
                                    <div class="text-center py-2 text-sm font-bold rounded-lg transition-all peer-checked:bg-white peer-checked:text-emerald-700 text-emerald-100 hover:text-white">Pengeluaran</div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-emerald-200">Keterangan / Deskripsi</label>
                            <input type="text" name="keterangan" required class="w-full mt-1 rounded-xl bg-white/10 border border-emerald-400/30 text-white placeholder-emerald-300 focus:ring-2 focus:ring-white px-4 py-2" placeholder="Contoh: Beli beras 10kg">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-emerald-200">Nominal (Rp)</label>
                            <input type="number" name="nominal" min="1" required class="w-full mt-1 rounded-xl bg-white/10 border border-emerald-400/30 text-white placeholder-emerald-300 focus:ring-2 focus:ring-white px-4 py-2" placeholder="50000">
                        </div>

                        <button type="submit" class="w-full bg-white text-emerald-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors shadow-md mt-2">
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
                
            </div>

        </div>
    </div>

    <!-- Script Inisialisasi Grafik Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Disetujui', 'Ditolak'],
                    datasets: [{
                        data: [{{ $pending }}, {{ $disetujui }}, {{ $ditolak }}],
                        backgroundColor: ['#FBBF24', '#10B981', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { font: { family: 'Figtree', weight: 'bold' } } }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</x-app-layout>
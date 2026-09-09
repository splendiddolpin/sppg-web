<x-app-layout>
    <div class="py-10 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h2 class="font-black text-4xl text-gray-900 tracking-tight">
                    Transparansi <span class="text-blue-600">Kas SPPG</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Laporan keuangan terbuka Pemasukan dan Pengeluaran SPPG Borobudur.</p>
            </div>

            <!-- Kartu Ringkasan Keuangan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <p class="text-blue-200 font-bold text-sm mb-1 relative z-10">Total Saldo Kas Saat Ini</p>
                    <h3 class="text-4xl font-black relative z-10">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
                
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
                    <p class="text-gray-400 font-bold text-sm mb-1">Total Pemasukan</p>
                    <h3 class="text-2xl font-black text-green-500">+ Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                </div>
                
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
                    <p class="text-gray-400 font-bold text-sm mb-1">Total Pengeluaran</p>
                    <h3 class="text-2xl font-black text-red-500">- Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Tabel Riwayat Transaksi Publik -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h3 class="font-bold text-lg text-gray-900">Riwayat Transaksi Terbaru</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">Tanggal</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">Keterangan</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase border-b border-gray-100 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kasItems as $kas)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">
                                        {{ \Carbon\Carbon::parse($kas->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $kas->keterangan }}</div>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md mt-1 inline-block {{ $kas->jenis == 'Pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $kas->jenis }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-black {{ $kas->jenis == 'Pemasukan' ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $kas->jenis == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-gray-400 font-bold text-sm">
                                        Belum ada catatan keuangan kas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
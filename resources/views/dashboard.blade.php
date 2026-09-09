<x-app-layout>
    <div class="py-10 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Sapaan -->
            <div class="mb-8">
                <h2 class="font-black text-3xl text-gray-900 tracking-tight">
                    Halo, <span class="text-blue-600">{{ Auth::user()->name }}</span> 👋
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Ini adalah ringkasan operasional dan daftar request menu terbaru.</p>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-8 bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-2xl shadow-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mini KPI / Metrik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Request</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $total }}</h3>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Menunggu (Pending)</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $pending }}</h3>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Telah Disetujui</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $disetujui }}</h3>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Request Menu -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
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
                                            <!-- Tombol Setujui -->
                                            <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="p-2 rounded-lg text-green-600 hover:bg-green-50 transition-colors tooltip" title="Setujui">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Tombol Tolak -->
                                            <form action="{{ route('request-menu.update-status', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
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
                                    <td colspan="5" class="px-8 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p class="text-sm font-bold">Belum ada request menu masuk.</p>
                                        </div>
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
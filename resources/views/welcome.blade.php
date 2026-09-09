<x-app-layout>
    
    <!-- Hero Section (Dinaikkan sedikit agar menyatu dengan navbar) -->
    <div class="relative bg-white pt-16 pb-12 lg:pt-24 lg:pb-20 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">Profil SPPG</span>
                <span class="block text-emerald-600">Magelang Borobudur</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Sistem Informasi Terpadu untuk pemantauan AKG, Request Menu, Indikator Kinerja, dan Pengelolaan Kas secara transparan dan efisien.
            </p>
        </div>
    </div>

    <!-- Bagian Tengah: Profil & AKG -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Card Profil -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Profil SPPG</h3>
                    <p class="text-gray-600 leading-relaxed">
                        SPPG Magelang Borobudur merupakan pusat pengelolaan operasional yang berdedikasi untuk memberikan layanan terbaik. Bagian ini nantinya dapat diisi dengan sejarah, visi, misi, serta struktur organisasi.
                    </p>
                </div>

                <!-- Card AKG Modern -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 transition duration-300 hover:shadow-md overflow-hidden flex flex-col">
                    <!-- Header Card -->
                    <div class="bg-emerald-600 px-6 py-5 flex justify-between items-center text-white">
                        <div>
                            <h3 class="text-xl font-bold">AKG Menu Hari Ini</h3>
                            <p class="text-emerald-100 text-sm mt-1">Kategori: Kecil / Balita</p>
                        </div>
                        <div class="text-right">
                            <p class="text-emerald-200 text-xs uppercase tracking-wider font-semibold">Tanggal</p>
                            <p class="font-bold">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Konten Data Nutrisi -->
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        
                        <!-- Grid Bento Box Nutrisi -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <!-- Energi -->
                            <div class="bg-orange-50 rounded-xl p-4 border border-orange-100 hover:shadow-md transition">
                                <div class="flex items-center text-orange-500 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Energi</span>
                                </div>
                                <div class="text-2xl font-black text-gray-800">408,7 <span class="text-sm font-medium text-gray-500">kkal</span></div>
                            </div>

                            <!-- Karbohidrat -->
                            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 hover:shadow-md transition">
                                <div class="flex items-center text-emerald-600 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Karbohidrat</span>
                                </div>
                                <div class="text-2xl font-black text-gray-800">51,6 <span class="text-sm font-medium text-gray-500">g</span></div>
                            </div>

                            <!-- Protein -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 hover:shadow-md transition">
                                <div class="flex items-center text-blue-500 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Protein</span>
                                </div>
                                <div class="text-2xl font-black text-gray-800">20,9 <span class="text-sm font-medium text-gray-500">g</span></div>
                            </div>

                            <!-- Lemak -->
                            <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100 hover:shadow-md transition">
                                <div class="flex items-center text-yellow-600 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Lemak</span>
                                </div>
                                <div class="text-2xl font-black text-gray-800">13,9 <span class="text-sm font-medium text-gray-500">g</span></div>
                            </div>
                            
                            <!-- Serat (Membentang Penuh) -->
                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-100 col-span-2 flex justify-between items-center hover:shadow-md transition">
                                <div>
                                    <div class="flex items-center text-purple-500 mb-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                        <span class="text-xs font-bold uppercase tracking-wider">Serat</span>
                                    </div>
                                    <div class="text-2xl font-black text-gray-800">2,8 <span class="text-sm font-medium text-gray-500">g</span></div>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-400">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10s10-4.48 10-10C22 6.48 17.52 2 12 2zm1 14.86V14h-2v2.86C7.54 16.35 4.5 13.06 4.5 9c0-.55.45-1 1-1h1.5l1-2h4l1 2h1.5c.55 0 1 .45 1 1 0 4.06-3.04 7.35-6.5 7.86z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Highlight Porsi Hari Ini -->
                        <div class="mt-auto bg-emerald-600 text-white rounded-xl p-4 flex items-center justify-center shadow-md hover:bg-emerald-700 transition cursor-default">
                            <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <div class="flex items-baseline">
                                <span class="text-sm font-medium text-emerald-100 mr-2">Total Produksi:</span>
                                <span class="text-2xl font-black tracking-tight">645 Porsi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Bawah: Instagram Feed -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-16">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 w-full overflow-hidden">
                <!-- Header IG -->
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 rounded-lg flex shrink-0 items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="text-lg font-bold text-gray-900 truncate">@sppg.magelangborobudur</h3>
                        <a href="https://www.instagram.com/sppg.magelangborobudur/" target="_blank" class="text-sm text-blue-500 hover:underline">Lihat di Instagram</a>
                    </div>
                </div>
                
                <div class="w-full relative">
                    <div class="sk-instagram-feed w-full" data-embed-id="25712216"></div>
                    <script src="https://widgets.sociablekit.com/instagram-feed/widget.js" defer></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
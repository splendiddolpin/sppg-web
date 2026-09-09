<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPPG Magelang Borobudur</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">SPPG</span>
                </div>
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <!-- Navigasi ini disiapkan untuk tahap selanjutnya -->
                    <a href="#" class="text-gray-900 border-b-2 border-blue-500 px-1 pt-1 text-sm font-medium">Beranda</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 px-1 pt-1 text-sm font-medium">Request Menu</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 px-1 pt-1 text-sm font-medium">KPI</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 px-1 pt-1 text-sm font-medium">Kas SPPG</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="ml-4 text-blue-600 font-medium hover:underline">Log in</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white pt-24 pb-12 lg:pt-32 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">Profil SPPG</span>
                <span class="block text-blue-600">Magelang Borobudur</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Sistem Informasi Terpadu untuk pemantauan AKG, Request Menu, Indikator Kinerja, dan Pengelolaan Kas secara transparan dan efisien.
            </p>
        </div>
    </div>

    <!-- Bagian Atas: Profil & AKG (Bersebelahan di layar lebar) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Card Profil -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Profil SPPG</h3>
                <p class="text-gray-600 leading-relaxed">
                    SPPG Magelang Borobudur merupakan pusat pengelolaan operasional yang berdedikasi untuk memberikan layanan terbaik. Bagian ini nantinya dapat diisi dengan sejarah, visi, misi, serta struktur organisasi.
                </p>
            </div>

            <!-- Card AKG -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Informasi AKG</h3>
                <p class="text-gray-600 leading-relaxed">
                    Sistem pemantauan AKG (Angka Kecukupan Gizi / Asesmen Kinerja) terintegrasi. Menampilkan data analitik secara real-time untuk memastikan setiap target terpenuhi.
                </p>
            </div>

        </div>
    </div>

    <!-- Bagian Bawah: Instagram Feed (Satu Baris Penuh) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 w-full overflow-hidden">
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
            
            <!-- Area Widget IG -->
            <div class="w-full relative">
                <div class="sk-instagram-feed w-full" data-embed-id="25712216"></div>
                <script src="https://widgets.sociablekit.com/instagram-feed/widget.js" defer></script>
            </div>
        </div>
    </div>

</body>
</html>
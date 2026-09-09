<nav x-data="{ open: false }" class="bg-white/60 backdrop-blur-md border-b border-gray-200/50 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <!-- Logo & Nav Kiri -->
            <div class="flex items-center gap-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                        <span class="text-white font-black text-xl">S</span>
                    </div>
                    <span class="text-2xl font-extrabold text-blue-700 tracking-tight">SPPG</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:space-x-1">
                    <a href="{{ url('/') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-200 {{ request()->is('/') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-100/80 hover:text-gray-900' }}">
                        Beranda
                    </a>
                    <a href="{{ route('request-menu.index') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-200 {{ request()->routeIs('request-menu.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-100/80 hover:text-gray-900' }}">
                        Request Menu
                    </a>
                    <a href="{{ route('kas.publik') }}" 
                    class="px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-200 {{ request()->routeIs('kas.publik') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-100/80 hover:text-gray-900' }}">
                        Kas SPPG
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-100/80 hover:text-gray-900' }}">
                            Dashboard Admin
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Bagian Kanan -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 pl-4 pr-2 py-1.5 border border-gray-200 rounded-full bg-white/50 hover:bg-white transition-all shadow-sm">
                                <span class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-black text-xs uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profil') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                        Petugas Log in
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'bg-white/95 backdrop-blur-xl shadow-md border-slate-200/60' : 'bg-white/80 backdrop-blur-md border-slate-200/30'"
     class="sticky top-0 z-[1000] border-b transition-all duration-300">
     
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="/" class="shrink-0 flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1e3a8a] to-[#2563eb] rounded-xl flex items-center justify-center text-white font-black text-xl shadow-[0_4px_10px_rgba(37,99,235,0.3)] group-hover:scale-105 transition-transform duration-300">S</div>
                    <span class="font-black text-2xl text-slate-800 tracking-tighter group-hover:text-[#2563eb] transition-colors">SPPG</span>
                </a>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-1 mt-1">
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 {{ request()->is('/') ? 'bg-blue-50 text-[#2563eb]' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">Beranda</a>
                    <a href="{{ route('request-menu.index') }}" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 {{ request()->routeIs('request-menu.*') ? 'bg-blue-50 text-[#2563eb]' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">Request Menu</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-[#2563eb]' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">Dashboard Admin</a>
                    @endauth
                </div>
            </div>

            <!-- Settings (Desktop) -->
            <div class="hidden md:flex items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 px-2 py-1.5 border border-slate-200 rounded-full bg-white hover:bg-slate-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2563eb]/20">
                                <div class="w-8 h-8 bg-gradient-to-tr from-blue-100 to-blue-200 text-[#2563eb] rounded-full flex items-center justify-center text-xs font-black">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <span class="text-xs font-bold text-slate-700 pr-2">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-bold text-xs uppercase tracking-wider text-slate-600">Profil Saya</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-bold text-xs uppercase tracking-wider text-red-600">Logout</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-white bg-[#2563eb] px-6 py-3 rounded-full hover:bg-blue-700 hover:shadow-[0_0_15px_rgba(37,99,235,0.4)] transition-all transform hover:-translate-y-0.5">Login Admin</a>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="flex items-center md:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 focus:outline-none transition-colors border border-slate-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         style="display: none;" 
         class="md:hidden absolute top-20 left-0 w-full bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-2xl z-50">
         
        <div class="px-4 py-4 flex flex-col gap-2">
            <a href="{{ url('/') }}" class="block px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest {{ request()->is('/') ? 'bg-[#2563eb] text-white' : 'bg-slate-50 text-slate-600' }}">Beranda</a>
            <a href="{{ route('request-menu.index') }}" class="block px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest {{ request()->routeIs('request-menu.*') ? 'bg-[#2563eb] text-white' : 'bg-slate-50 text-slate-600' }}">Request Menu</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'bg-[#2563eb] text-white' : 'bg-slate-50 text-slate-600' }}">Dashboard Admin</a>
            @endauth
        </div>

        <div class="pt-4 pb-6 px-4 border-t border-slate-100 bg-slate-50">
            @auth
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 bg-blue-100 text-[#2563eb] rounded-full flex items-center justify-center text-sm font-black">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="font-black text-sm text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="font-bold text-[10px] text-slate-500 uppercase tracking-wider">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest bg-white text-slate-600 border border-slate-200">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100">Logout</a>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest bg-[#2563eb] text-white shadow-lg">Login Admin</a>
            @endauth
        </div>
    </div>
</nav>
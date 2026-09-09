<x-app-layout>
    <style>
        body, html { background-color: #F8FAFC !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="py-10 bg-[#F8FAFC] min-h-screen" x-data="menuBuilder()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="font-black text-4xl text-gray-900 tracking-tight">
                        Susun <span class="text-blue-600">Menu MBG</span>
                    </h2>
                    <p class="text-gray-500 mt-2 font-medium">Pilih kombinasi menu harian sesuai standar anggaran.</p>
                </div>
                <!-- Tombol Pemilih Porsi Dinamis -->
                <div class="mt-4 md:mt-0 flex gap-2 bg-gray-100/50 p-1 rounded-full border border-gray-200">
                    <button @click="porsi = 'kecil'"
                            :class="porsi === 'kecil' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
                        Porsi Kecil
                    </button>
                    <button @click="porsi = 'besar'"
                            :class="porsi === 'besar' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300">
                        Porsi Besar
                    </button>
                </div>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm font-bold">
                    ✨ {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- KIRI: Daftar Menu -->
                <div class="flex-1">
                    <div class="flex space-x-3 overflow-x-auto pb-4 mb-6 scrollbar-hide">
                        <template x-for="cat in categories" :key="cat.name">
                            <button @click="activeTab = cat.name"
                                    :class="activeTab === cat.name 
                                        ? 'bg-blue-600 text-white shadow-md' 
                                        : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300'"
                                    class="px-5 py-2.5 rounded-full text-sm font-bold whitespace-nowrap transition-all flex items-center gap-2">
                                <span x-text="cat.icon" class="text-lg"></span>
                                <span x-text="cat.name"></span>
                            </button>
                        </template>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <template x-for="item in filteredMenu" :key="item.id">
                            <div @click="toggleItem(item)"
                                 :class="isSelected(item) ? 'border-blue-500 ring-2 ring-blue-100 bg-blue-50/30' : 'border-gray-200 bg-white hover:border-blue-300'"
                                 class="rounded-2xl p-6 border cursor-pointer transition-all flex justify-between items-center group">
                                
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base" x-text="item.name"></h3>
                                    <p class="text-blue-600 font-extrabold text-sm mt-1" x-text="formatRupiah(item.price)"></p>
                                </div>
                                
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all"
                                     :class="isSelected(item) ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300 text-transparent'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- KANAN: Sidebar Cart -->
                <div class="w-full lg:w-[400px] shrink-0">
                    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 sticky top-28 overflow-hidden">
                        
                        <div class="p-8 pb-6 border-b border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Ringkasan</h3>
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-full transition-all" x-text="'Maks ' + formatRupiah(maxBudget)"></span>
                            </div>
                            
                            <p class="text-gray-500 text-sm font-semibold mb-1">Total Biaya</p>
                            <h2 class="text-4xl font-black text-gray-900 tracking-tight transition-all" x-text="formatRupiah(totalCost)"></h2>
                            
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-6 overflow-hidden">
                                <div class="h-1.5 rounded-full transition-all duration-500" 
                                     :style="`width: ${budgetPercentage}%`" 
                                     :class="budgetPercentage > 100 ? 'bg-red-500' : 'bg-blue-500'"></div>
                            </div>
                        </div>

                        <div class="p-8 pt-4 space-y-4 max-h-[350px] overflow-y-auto">
                            <template x-for="item in selectedItems" :key="'cart-'+item.id">
                                <div x-transition class="flex justify-between items-center group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-lg" x-text="categories.find(c => c.name === item.category).icon"></div>
                                        <div>
                                            <span class="text-gray-900 font-bold text-sm block" x-text="item.name"></span>
                                            <span class="text-gray-500 font-semibold text-xs" x-text="formatRupiah(item.price)"></span>
                                        </div>
                                    </div>
                                    <button @click="removeItem(item)" class="text-gray-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                            
                            <div x-show="selectedItems.length === 0" class="text-center py-8">
                                <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-400">Keranjang Kosong</p>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                            <p x-show="totalCost > maxBudget" class="text-red-500 text-xs font-bold text-center mb-3 transition-all">Melebihi batas anggaran!</p>
                            
                            <form action="{{ route('request-menu.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="nama_menu" :value="selectedItems.length > 0 ? selectedItems.map(i => i.name).join(', ') : ''">
                                <!-- Modifikasi agar tipe porsi masuk ke database -->
                                <input type="hidden" name="deskripsi" :value="selectedItems.length > 0 ? 'Porsi ' + (porsi === 'kecil' ? 'Kecil' : 'Besar') + ' | Total Anggaran: ' + formatRupiah(totalCost) : ''">
                                
                                <button type="submit" 
                                        :disabled="selectedItems.length === 0 || totalCost > maxBudget"
                                        :class="(selectedItems.length === 0 || totalCost > maxBudget) ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-md'"
                                        class="w-full font-bold py-3.5 px-4 rounded-xl transition-all flex justify-center items-center gap-2">
                                    Kirim Request Menu
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function menuBuilder() {
            return {
                porsi: 'kecil', // Default awal porsi kecil
                
                // Nilai maxBudget sekarang bereaksi secara otomatis terhadap tipe porsi
                get maxBudget() {
                    return this.porsi === 'kecil' ? 8000 : 10000;
                },
                
                activeTab: 'Karbohidrat',
                categories: [
                    { name: 'Karbohidrat', icon: '🍚' }, { name: 'Protein Hewani', icon: '🍗' },
                    { name: 'Protein Nabati', icon: '🥜' }, { name: 'Sayur', icon: '🥬' },
                    { name: 'Buah', icon: '🍎' }, { name: 'Susu', icon: '🥛' }
                ],
                menuItems: [
                    { id: 1, name: 'Jagung Rebus', price: 3500, category: 'Karbohidrat' },
                    { id: 2, name: 'Kentang Perkedel', price: 3000, category: 'Karbohidrat' },
                    { id: 3, name: 'Nasi Biru', price: 2000, category: 'Karbohidrat' },
                    { id: 4, name: 'Nasi Kuning', price: 2000, category: 'Karbohidrat' },
                    { id: 5, name: 'Ayam Bakar', price: 4500, category: 'Protein Hewani' },
                    { id: 6, name: 'Telur Dadar', price: 2500, category: 'Protein Hewani' },
                    { id: 7, name: 'Tempe Goreng', price: 1000, category: 'Protein Nabati' },
                    { id: 8, name: 'Tahu Isi', price: 1500, category: 'Protein Nabati' },
                    { id: 9, name: 'Sayur Bayam', price: 2000, category: 'Sayur' },
                    { id: 10, name: 'Tumis Buncis', price: 2500, category: 'Sayur' },
                    { id: 11, name: 'Pisang', price: 1500, category: 'Buah' },
                    { id: 12, name: 'Susu UHT Mini', price: 3000, category: 'Susu' },
                ],
                selectedItems: [],
                get totalCost() { return this.selectedItems.reduce((sum, item) => sum + item.price, 0); },
                get budgetPercentage() { return (this.totalCost / this.maxBudget) * 100; },
                get filteredMenu() { return this.menuItems.filter(item => item.category === this.activeTab); },
                toggleItem(item) {
                    const idx = this.selectedItems.findIndex(i => i.id === item.id);
                    if (idx > -1) this.selectedItems.splice(idx, 1); else this.selectedItems.push(item);
                },
                isSelected(item) { return this.selectedItems.some(i => i.id === item.id); },
                removeItem(item) {
                    const idx = this.selectedItems.findIndex(i => i.id === item.id);
                    if (idx > -1) this.selectedItems.splice(idx, 1);
                },
                formatRupiah(number) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number); }
            }
        }
    </script>
</x-app-layout>
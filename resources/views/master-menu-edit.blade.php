<x-app-layout>
    <div class="py-12 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 hover:shadow-md transition-all border border-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">Edit <span class="text-blue-600">Master Menu</span></h2>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <form action="{{ route('master-menu.update', $menu->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="text-sm font-bold text-gray-700">Nama Menu</label>
                        <input type="text" name="nama" value="{{ $menu->nama }}" required class="w-full mt-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent px-4 py-3">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-bold text-gray-700">Kategori</label>
                            <select name="kategori" required class="w-full mt-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 px-4 py-3">
                                <option value="Karbohidrat" {{ $menu->kategori == 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat</option>
                                <option value="Protein Hewani" {{ $menu->kategori == 'Protein Hewani' ? 'selected' : '' }}>Protein Hewani</option>
                                <option value="Protein Nabati" {{ $menu->kategori == 'Protein Nabati' ? 'selected' : '' }}>Protein Nabati</option>
                                <option value="Sayur" {{ $menu->kategori == 'Sayur' ? 'selected' : '' }}>Sayur</option>
                                <option value="Buah" {{ $menu->kategori == 'Buah' ? 'selected' : '' }}>Buah</option>
                                <option value="Susu" {{ $menu->kategori == 'Susu' ? 'selected' : '' }}>Susu</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-bold text-gray-700">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ $menu->harga }}" required class="w-full mt-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:ring-2 focus:ring-blue-500 px-4 py-3">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-colors shadow-md shadow-blue-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>
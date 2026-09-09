<x-app-layout>
    <div class="py-10 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                
                <h2 class="font-black text-2xl text-gray-900 mb-6">Edit Request Menu</h2>

                <form action="{{ route('request-menu.update', $requestMenu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Menu</label>
                        <input type="text" name="nama_menu" value="{{ old('nama_menu', $requestMenu->nama_menu) }}" 
                               class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Porsi & Anggaran</label>
                        <textarea name="deskripsi" rows="3" 
                                  class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm">{{ old('deskripsi', $requestMenu->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            <option value="Pending" {{ $requestMenu->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ $requestMenu->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $requestMenu->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    // Menyimpan menu baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255', 
            'kategori' => 'required|string', 
            'harga' => 'required|numeric'
        ]);

        // Menggunakan $validatedData jauh lebih aman daripada $request->all()
        // karena _token otomatis diabaikan.
        MenuItem::create($validatedData);

        return back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit
    public function edit($id)
    {
        $menu = MenuItem::findOrFail($id);
        return view('master-menu-edit', compact('menu'));
    }

    // Menyimpan perubahan edit menu
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255', 
            'kategori' => 'required|string', 
            'harga' => 'required|numeric'
        ]);

        $menu = MenuItem::findOrFail($id);
        $menu->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Data menu diperbarui!');
    }

    // Menghapus menu
    public function destroy($id)
    {
        MenuItem::findOrFail($id)->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }
}
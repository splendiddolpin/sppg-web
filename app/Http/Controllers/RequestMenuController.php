<?php

namespace App\Http\Controllers;

use App\Models\RequestMenu;
use App\Models\MenuItem; // Pastikan model ini di-import
use Illuminate\Http\Request;

class RequestMenuController extends Controller
{
    // Menampilkan halaman Request Menu Publik
    public function index()
    {
        // Ambil semua data Master Menu dari database
        $masterMenu = MenuItem::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->nama,
                'price' => $item->harga,
                'category' => $item->kategori,
            ];
        });

        // Kirim data ke view
        return view('request-menu', compact('masterMenu'));
    }

    // Menyimpan data pengajuan dari pengunjung
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        RequestMenu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Request Menu berhasil diajukan!');
    }

    // Admin merubah status (Pending/Disetujui/Ditolak)
    public function updateStatus(Request $request, $id)
    {
        $requestMenu = RequestMenu::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Pending'
        ]);

        $requestMenu->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status request berhasil diperbarui!');
    }
}
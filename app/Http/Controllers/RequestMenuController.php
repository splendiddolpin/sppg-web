<?php

namespace App\Http\Controllers;

use App\Models\RequestMenu;
use Illuminate\Http\Request;

class RequestMenuController extends Controller
{
    public function index()
    {
        $requests = RequestMenu::latest()->get(); 
        return view('request-menu', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        RequestMenu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending', // Status awal selalu Pending
        ]);

        return redirect()->back()->with('success', 'Request Menu berhasil diajukan!');
    }
    

    // FUNGSI BARU UNTUK ADMIN MENGUBAH STATUS
    public function updateStatus(Request $request, $id)
    {
        $requestMenu = RequestMenu::findOrFail($id);
        
        // Validasi agar status yang masuk hanya boleh Disetujui atau Ditolak
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Pending'
        ]);

        $requestMenu->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status request berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\RequestMenu;
use Illuminate\Http\Request;

class RequestMenuController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari yang paling baru
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
        ]);

        return redirect()->back()->with('success', 'Request Menu berhasil diajukan!');
    }
}
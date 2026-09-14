<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasSppg;

class KasController extends Controller
{
    public function store(Request $request)
    {
        // Validasi yang mengizinkan semua jenis pengeluaran baru
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran Umum,Reimburse Mitra,Reimburse Operasional,Reimburse CV (Bahan Baku)',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1'
        ]);

        KasSppg::create($request->all());
        
        return back()->with('success', 'Catatan kas & reimburse berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        KasSppg::findOrFail($id)->delete();
        return back()->with('success', 'Catatan kas berhasil dihapus!');
    }

    public function lunas($id)
    {
        $kas = KasSppg::findOrFail($id);
        $kas->status = 'Lunas';
        $kas->save();
        
        return back()->with('success', 'Dana reimburse berhasil dicairkan/dilunasi!');
    }
}
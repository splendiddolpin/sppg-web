<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestMenuController;
use App\Models\RequestMenu;
use App\Models\MenuItem;
use App\Models\KasSppg;
use App\Models\Akg;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\KasController; // <-- Tambahan Baru

// ==========================================
// ROUTE PUBLIK (Beranda & Request Menu)
// ==========================================
Route::get('/', function () {
    $akgKecil = Akg::firstOrCreate(['jenis_porsi' => 'Kecil'], [
        'energi' => 408.7, 'karbohidrat' => 51.6, 'protein' => 20.9, 'lemak' => 13.9, 'serat' => 2.8, 'total_produksi' => 647
    ]);
    $akgBesar = Akg::firstOrCreate(['jenis_porsi' => 'Besar'], [
        'energi' => 480.1, 'karbohidrat' => 58.5, 'protein' => 22.7, 'lemak' => 14.6, 'serat' => 3.2, 'total_produksi' => 1355
    ]);
    return view('welcome', compact('akgKecil', 'akgBesar'));
});

Route::get('/informasi-bgn', function () {
    return view('bgn-info');
})->name('bgn.info');

Route::post('/api/scan-akg', [AiController::class, 'scanAkg'])->name('api.scan-akg');
Route::get('/request-menu', [RequestMenuController::class, 'index'])->name('request-menu.index');
Route::post('/request-menu', [RequestMenuController::class, 'store'])->name('request-menu.store')->middleware('throttle:3,1');

// ==========================================
// ROUTE ADMIN (Wajib login)
// ==========================================
Route::get('/dashboard', function () {
    $requests = RequestMenu::latest()->get();
    
    // KPI Data
    $total = $requests->count();
    $pending = $requests->where('status', 'Pending')->count();
    $disetujui = $requests->where('status', 'Disetujui')->count();
    $ditolak = $requests->where('status', 'Ditolak')->count();

    // Master Menu
    $menuItems = MenuItem::latest()->get();

    // ==================================================
    // LOGIKA KAS BARU (SISTEM DANA TALANGAN & FIX DATA LAMA)
    // ==================================================
    $kasItems = KasSppg::orderBy('tanggal', 'desc')->latest()->get();
    
    // 1. Pemasukan Murni
    $pemasukan = $kasItems->where('jenis', 'Pemasukan')->sum('nominal');
    
    // 2. Pengeluaran Umum (whereIn digunakan agar data lama 'Pengeluaran' tetap terbaca)
    $pengeluaranUmum = $kasItems->whereIn('jenis', ['Pengeluaran', 'Pengeluaran Umum'])->sum('nominal');
    
    // 3. LOGIKA REIMBURSE (Abaikan sepenuhnya jika statusnya Lunas)
    $reimburseMitra = $kasItems->where('jenis', 'Reimburse Mitra')
                               ->where('status', '!=', 'Lunas')
                               ->sum('nominal');
                               
    $reimburseOperasional = $kasItems->where('jenis', 'Reimburse Operasional')
                                     ->where('status', '!=', 'Lunas')
                                     ->sum('nominal');
                                     
    $reimburseCV = $kasItems->where('jenis', 'Reimburse CV (Bahan Baku)')
                            ->where('status', '!=', 'Lunas')
                            ->sum('nominal');

    // 4. Hitung Total Pengeluaran Nyata
    $pengeluaran = $pengeluaranUmum + $reimburseMitra + $reimburseOperasional + $reimburseCV;
    
    // 5. Saldo Akhir
    $saldo = $pemasukan - $pengeluaran;

    // CATATAN: Jangan tambahkan kode perhitungan rincian lagi di bawah sini, 
    // karena variabelnya sudah dihitung dengan benar di Langkah 2 & 3.
    
    // Menu Terfavorit
    $menuCounts = [];
    foreach ($requests as $req) {
        if (!empty($req->nama_menu)) {
            $items = explode(',', $req->nama_menu);
            foreach ($items as $item) {
                $itemName = trim($item);
                if (!empty($itemName)) {
                    if (isset($menuCounts[$itemName])) {
                        $menuCounts[$itemName]++;
                    } else {
                        $menuCounts[$itemName] = 1;
                    }
                }
            }
        }
    }
    $topMenus = collect($menuCounts)->sortDesc()->take(5);

    return view('dashboard', compact(
        'requests', 'total', 'pending', 'disetujui', 'ditolak', 
        'menuItems', 'topMenus', 'kasItems', 'pemasukan', 'pengeluaran', 'saldo',
        'pengeluaranUmum', 'reimburseMitra', 'reimburseOperasional', 'reimburseCV'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// ROUTE AKSI KHUSUS ADMIN
// ==========================================
Route::middleware('auth')->group(function () {
    // Manajemen Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Status Request
    Route::patch('/request-menu/{id}/status', [RequestMenuController::class, 'updateStatus'])->name('request-menu.update-status');
    
    // CRUD Master Menu
    Route::post('/master-menu', [MenuItemController::class, 'store'])->name('master-menu.store');
    Route::get('/master-menu/{id}/edit', [MenuItemController::class, 'edit'])->name('master-menu.edit');
    Route::put('/master-menu/{id}', [MenuItemController::class, 'update'])->name('master-menu.update');
    Route::delete('/master-menu/{id}', [MenuItemController::class, 'destroy'])->name('master-menu.destroy');

    // ==================================================
    // CRUD Kas SPPG (Sekarang Menggunakan Controller!)
    // ==================================================
    Route::get('/kas-sppg', function () { return redirect('/'); });
    Route::post('/kas-sppg', [KasController::class, 'store'])->name('kas.store');
    Route::delete('/kas-sppg/{id}', [KasController::class, 'destroy'])->name('kas.destroy');
    
    // RUTE BARU UNTUK PELUNASAN REIMBURSE
    Route::patch('/kas-sppg/{id}/lunas', [KasController::class, 'lunas'])->name('kas.lunas');

    // Update AKG Beranda
    Route::put('/akg/{id}', function(Request $request, $id) {
        $request->validate([
            'energi' => 'required|numeric', 'karbohidrat' => 'required|numeric',
            'protein' => 'required|numeric', 'lemak' => 'required|numeric',
            'serat' => 'required|numeric', 'total_produksi' => 'required|numeric',
            'opsi_tanggal' => 'required|in:server,manual',
            'tanggal_manual' => 'nullable|date',
        ]);
        
        $akg = Akg::findOrFail($id);
        $data = $request->except(['_token', '_method', 'opsi_tanggal', 'tanggal_manual']);
        
        $waktuBaru = now();
        if ($request->opsi_tanggal === 'manual' && $request->tanggal_manual) {
            $waktuBaru = $request->tanggal_manual . ' ' . now()->format('H:i:s');
        }

        $akg->timestamps = false; 
        $akg->fill($data);
        $akg->updated_at = $waktuBaru;
        $akg->save();

        Akg::where('id', '!=', $id)->update(['updated_at' => $waktuBaru]);
        
        return back()->with('success', 'Data AKG & Tanggal berhasil diperbarui!');
    })->name('akg.update');
});

require __DIR__.'/auth.php';
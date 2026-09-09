<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestMenuController;
use App\Models\RequestMenu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\KasSppg;
use App\Models\Akg;

// ROUTE PUBLIK (Beranda)
Route::get('/', function () {
    // firstOrCreate akan otomatis membuat data default jika database masih kosong!
    $akgKecil = Akg::firstOrCreate(['jenis_porsi' => 'Kecil'], [
        'energi' => 408.7, 'karbohidrat' => 51.6, 'protein' => 20.9, 'lemak' => 13.9, 'serat' => 2.8, 'total_produksi' => 645
    ]);
    $akgBesar = Akg::firstOrCreate(['jenis_porsi' => 'Besar'], [
        'energi' => 650.0, 'karbohidrat' => 75.0, 'protein' => 30.0, 'lemak' => 20.0, 'serat' => 4.5, 'total_produksi' => 300
    ]);

    return view('welcome', compact('akgKecil', 'akgBesar'));
});

// ==========================================
// ROUTE PUBLIK (Tidak perlu login)
// ==========================================
Route::get('/request-menu', [RequestMenuController::class, 'index'])->name('request-menu.index');
Route::post('/request-menu', [RequestMenuController::class, 'store'])->name('request-menu.store')->middleware('throttle:3,1');

// Halaman Transparansi Kas Publik
Route::get('/kas-sppg', function () {
    $kasItems = KasSppg::orderBy('tanggal', 'desc')->latest()->get();
    
    // Kalkulasi total
    $pemasukan = $kasItems->where('jenis', 'Pemasukan')->sum('nominal');
    $pengeluaran = $kasItems->where('jenis', 'Pengeluaran')->sum('nominal');
    $saldo = $pemasukan - $pengeluaran;

    return view('kas-publik', compact('kasItems', 'pemasukan', 'pengeluaran', 'saldo'));
})->name('kas.publik');


// ==========================================
// ROUTE ADMIN (Wajib login)
// ==========================================
// ==========================================
// ROUTE ADMIN (Wajib login)
// ==========================================
Route::get('/dashboard', function () {
    $requests = App\Models\RequestMenu::latest()->get();
    
    // Data KPI
    $total = $requests->count();
    $pending = $requests->where('status', 'Pending')->count();
    $disetujui = $requests->where('status', 'Disetujui')->count();
    $ditolak = $requests->where('status', 'Ditolak')->count();

    // Data Master Menu
    $menuItems = App\Models\MenuItem::latest()->get();

    // DATA BARU: Mengambil Data Kas SPPG
    $kasItems = App\Models\KasSppg::orderBy('tanggal', 'desc')->latest()->get();

    // Logika Menu Terfavorit
    $menuCounts = collect();
    foreach ($requests as $req) {
        if ($req->nama_menu) {
            $items = explode(', ', $req->nama_menu);
            foreach ($items as $item) {
                $itemName = trim($item);
                if (!empty($itemName)) {
                    if ($menuCounts->has($itemName)) {
                        $menuCounts[$itemName]++;
                    } else {
                        $menuCounts->put($itemName, 1);
                    }
                }
            }
        }
    }
    $topMenus = $menuCounts->sortDesc()->take(5);

    // Pastikan $kasItems ditambahkan ke dalam compact()
    return view('dashboard', compact('requests', 'total', 'pending', 'disetujui', 'ditolak', 'menuItems', 'topMenus', 'kasItems'));
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// GROUP MIDDLEWARE AUTH (Aksi Admin)
// ==========================================
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Setujui / Tolak Request Menu
    Route::patch('/request-menu/{id}/status', [RequestMenuController::class, 'updateStatus'])->name('request-menu.update-status');
    
    // ------------------------------------------
    // CRUD MASTER MENU
    // ------------------------------------------
    
    // 1. CREATE: Tambah Menu
    Route::post('/master-menu', function (Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric'
        ]);
        MenuItem::create($request->all());
        return back()->with('success', 'Menu baru berhasil ditambahkan!');
    })->name('master-menu.store');

    // 2. READ: Halaman Edit Menu
    Route::get('/master-menu/{id}/edit', function ($id) {
        $menu = MenuItem::findOrFail($id);
        return view('master-menu-edit', compact('menu'));
    })->name('master-menu.edit');

    // 3. UPDATE: Simpan Perubahan Menu
    Route::put('/master-menu/{id}', function (Request $request, $id) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric'
        ]);
        $menu = MenuItem::findOrFail($id);
        $menu->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Data menu berhasil diperbarui!');
    })->name('master-menu.update');

    // 4. DELETE: Hapus Menu
    Route::delete('/master-menu/{id}', function ($id) {
        MenuItem::findOrFail($id)->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    })->name('master-menu.destroy');

    // ------------------------------------------
    // CRUD KAS SPPG (ADMIN)
    // ------------------------------------------
    Route::post('/kas-sppg', function (Request $request) {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1'
        ]);
        KasSppg::create($request->all());
        return back()->with('success', 'Catatan kas berhasil ditambahkan!');
    })->name('kas.store');

    Route::delete('/kas-sppg/{id}', function ($id) {
        KasSppg::findOrFail($id)->delete();
        return back()->with('success', 'Catatan kas berhasil dihapus!');
    })->name('kas.destroy');

    // ROUTE BARU: Update AKG (Hanya untuk Admin)
    Route::put('/akg/{id}', function(Illuminate\Http\Request $request, $id) {
        $request->validate([
            'energi' => 'required|numeric', 'karbohidrat' => 'required|numeric',
            'protein' => 'required|numeric', 'lemak' => 'required|numeric',
            'serat' => 'required|numeric', 'total_produksi' => 'required|numeric',
        ]);
        Akg::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data AKG berhasil diperbarui!');
    })->name('akg.update');
});

require __DIR__.'/auth.php';
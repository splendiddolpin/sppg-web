<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestMenuController;
use App\Models\RequestMenu;

Route::get('/', function () {
    return view('welcome');
});

// ROUTE PUBLIK (Bisa diakses tanpa login)
Route::get('/request-menu', [RequestMenuController::class, 'index'])->name('request-menu.index');
Route::post('/request-menu', [RequestMenuController::class, 'store'])->name('request-menu.store')->middleware('throttle:3,1');

// ROUTE ADMIN (Wajib login)
Route::get('/dashboard', function () {
    // Mengambil data untuk tabel dan metrik KPI sederhana
    $requests = RequestMenu::latest()->get();
    $total = $requests->count();
    $pending = $requests->where('status', 'Pending')->count();
    $disetujui = $requests->where('status', 'Disetujui')->count();

    return view('dashboard', compact('requests', 'total', 'pending', 'disetujui'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
    // Rute untuk mengeksekusi update status request menu
    Route::patch('/request-menu/{id}/status', [RequestMenuController::class, 'updateStatus'])->name('request-menu.update-status');
});

require __DIR__.'/auth.php';
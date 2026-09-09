<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akg;
use Carbon\Carbon;

class AkgSeeder extends Seeder
{
    public function run(): void
    {
        // Set tanggal ke 9 September 2026
        $tanggalTetap = Carbon::create(2026, 9, 9, 8, 0, 0);

        // Kosongkan tabel terlebih dahulu agar data tidak ganda
        Akg::truncate();

        // Data AKG Porsi Kecil
        Akg::create([
            'jenis_porsi' => 'Kecil',
            'energi' => 408.7,
            'protein' => 20.9,
            'lemak' => 13.9,
            'karbohidrat' => 51.6,
            'serat' => 2.8,
            'total_produksi' => 647,
            'created_at' => $tanggalTetap,
            'updated_at' => $tanggalTetap,
        ]);

        // Data AKG Porsi Besar
        Akg::create([
            'jenis_porsi' => 'Besar',
            'energi' => 480.1,
            'protein' => 22.7,
            'lemak' => 14.6,
            'karbohidrat' => 58.5,
            'serat' => 3.2,
            'total_produksi' => 1355,
            'created_at' => $tanggalTetap,
            'updated_at' => $tanggalTetap,
        ]);
    }
}
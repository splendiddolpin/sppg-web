<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom 'status' jika belum ada
        Schema::table('kas_sppgs', function (Blueprint $table) {
            if (!Schema::hasColumn('kas_sppgs', 'status')) {
                $table->string('status', 50)->default('Pending')->after('nominal');
            }
        });

        // 2. Ubah kolom 'jenis' dari ENUM menjadi VARCHAR secara paksa agar lebih fleksibel
        // Menggunakan raw statement agar tidak butuh package tambahan di server
        DB::statement('ALTER TABLE kas_sppgs MODIFY jenis VARCHAR(255) NOT NULL');
    }

    public function down(): void
    {
        Schema::table('kas_sppgs', function (Blueprint $table) {
            if (Schema::hasColumn('kas_sppgs', 'status')) {
                $table->dropColumn('status');
            }
        });

        // Mengembalikan ke ENUM jika di-rollback (Opsional, disesuaikan dengan data awal)
        DB::statement("ALTER TABLE kas_sppgs MODIFY jenis ENUM('Pemasukan', 'Pengeluaran') NOT NULL");
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kas_sppgs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            
            // 1. Enum diganti menjadi string agar didukung penuh oleh SQLite & MySQL
            $table->string('jenis'); 
            
            $table->string('keterangan');
            $table->integer('nominal');
            
            // 2. Kolom status ditambahkan langsung di file utama
            $table->string('status', 50)->default('Pending'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_sppgs');
    }
};
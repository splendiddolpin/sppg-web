<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_sppgs', function (Blueprint $table) {
            // Menambahkan kolom status, defaultnya Pending, diletakkan setelah kolom nominal
            $table->string('status', 50)->default('Pending')->after('nominal');
        });
    }

    public function down(): void
    {
        Schema::table('kas_sppgs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
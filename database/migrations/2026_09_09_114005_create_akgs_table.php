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
    Schema::create('akgs', function (Blueprint $table) {
        $table->id();
        $table->string('jenis_porsi'); // Kecil atau Besar
        $table->float('energi');
        $table->float('karbohidrat');
        $table->float('protein');
        $table->float('lemak');
        $table->float('serat');
        $table->integer('total_produksi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akgs');
    }
};

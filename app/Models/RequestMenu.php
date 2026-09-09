<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMenu extends Model
{
    use HasFactory;

    // Baris ini adalah kuncinya: Memberikan izin kepada Laravel untuk mengisi kolom-kolom ini
    protected $fillable = [
        'nama_menu', 
        'deskripsi', 
        'status'
    ];
}
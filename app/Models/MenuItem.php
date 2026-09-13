<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    // WAJIB ADA: Mencegah MassAssignmentException
    protected $fillable = [
        'nama', 
        'kategori', 
        'harga'
    ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akg extends Model
{
    use HasFactory;
    protected $fillable = ['jenis_porsi', 'energi', 'karbohidrat', 'protein', 'lemak', 'serat', 'total_produksi'];
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            // Cari berdasarkan email ini
            ['email' => 'asistenlapangan676@gmail.com'],
            
            // Jika tidak ada buat baru, jika ada update dengan data ini
            [
                'name' => 'Staff SPPG Borobudur',
                'password' => Hash::make('password'), // Hash::make penting agar password dienkripsi dengan aman
            ]
        );
    }
}
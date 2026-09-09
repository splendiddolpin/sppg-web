<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // KARBOHIDRAT
            ['nama' => 'Nasi Putih', 'kategori' => 'Karbohidrat', 'harga' => 1500],
            ['nama' => 'Nasi Uduk', 'kategori' => 'Karbohidrat', 'harga' => 2500],
            ['nama' => 'Nasi Daun Jeruk', 'kategori' => 'Karbohidrat', 'harga' => 1700],
            ['nama' => 'Nasi Onigiri', 'kategori' => 'Karbohidrat', 'harga' => 2500],
            ['nama' => 'Nasi Sushi/Kimbab', 'kategori' => 'Karbohidrat', 'harga' => 2500],
            ['nama' => 'Nasi Kuning', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Nasi Biru', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Nasi Ungu', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Nasi Hijau', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Nasi Goreng', 'kategori' => 'Karbohidrat', 'harga' => 2500],
            ['nama' => 'Nasi Kebuli', 'kategori' => 'Karbohidrat', 'harga' => 3000],
            ['nama' => 'Kentang Rebus', 'kategori' => 'Karbohidrat', 'harga' => 2800],
            ['nama' => 'Potato Wedges', 'kategori' => 'Karbohidrat', 'harga' => 3000],
            ['nama' => 'Kentang Perkedel', 'kategori' => 'Karbohidrat', 'harga' => 3000],
            ['nama' => 'Ubi Ungu Rebus', 'kategori' => 'Karbohidrat', 'harga' => 2500],
            ['nama' => 'Ubi Ungu Cream Cheese', 'kategori' => 'Karbohidrat', 'harga' => 3400],
            ['nama' => 'Ubi Cilembu', 'kategori' => 'Karbohidrat', 'harga' => 3000],
            ['nama' => 'Singkong Rebus', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Mie Telur', 'kategori' => 'Karbohidrat', 'harga' => 2000],
            ['nama' => 'Mie Ramen', 'kategori' => 'Karbohidrat', 'harga' => 2200],
            ['nama' => 'Mie Spaghetti', 'kategori' => 'Karbohidrat', 'harga' => 2200],
            ['nama' => 'Jagung Rebus', 'kategori' => 'Karbohidrat', 'harga' => 3500],

            // PROTEIN HEWANI
            ['nama' => 'Ayam Goreng Kremes', 'kategori' => 'Protein Hewani', 'harga' => 4000],
            ['nama' => 'Ayam Lengkuas', 'kategori' => 'Protein Hewani', 'harga' => 4000],
            ['nama' => 'Ayam Geprek', 'kategori' => 'Protein Hewani', 'harga' => 4300],
            ['nama' => 'Ayam Saos Teriyaki', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Ayam Kecap Wijen', 'kategori' => 'Protein Hewani', 'harga' => 4300],
            ['nama' => 'Ayam Saos Barbeque', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Ayam Pop', 'kategori' => 'Protein Hewani', 'harga' => 4300],
            ['nama' => 'Ayam Katsu', 'kategori' => 'Protein Hewani', 'harga' => 4700],
            ['nama' => 'Chicken Wings BBQ', 'kategori' => 'Protein Hewani', 'harga' => 4300],
            ['nama' => 'Sate Ayam', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Sop Ayam', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Ikan Lele Goreng', 'kategori' => 'Protein Hewani', 'harga' => 4700],
            ['nama' => 'Ikan Lele Mangut', 'kategori' => 'Protein Hewani', 'harga' => 5000],
            ['nama' => 'Ikan Bandeng Goreng', 'kategori' => 'Protein Hewani', 'harga' => 3500],
            ['nama' => 'Ikan Dori', 'kategori' => 'Protein Hewani', 'harga' => 4000],
            ['nama' => 'Daging Sapi Rendang', 'kategori' => 'Protein Hewani', 'harga' => 4700],
            ['nama' => 'Sop Daging Sapi', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Abon Ayam', 'kategori' => 'Protein Hewani', 'harga' => 4000],
            ['nama' => 'Abon Sapi', 'kategori' => 'Protein Hewani', 'harga' => 6000],
            ['nama' => 'Abon Ikan', 'kategori' => 'Protein Hewani', 'harga' => 4500],
            ['nama' => 'Telur Ayam Rebus', 'kategori' => 'Protein Hewani', 'harga' => 2500],
            ['nama' => 'Telur Mata Sapi', 'kategori' => 'Protein Hewani', 'harga' => 2500],
            ['nama' => 'Telur Dadar', 'kategori' => 'Protein Hewani', 'harga' => 2000],
            ['nama' => 'Telur Saos Barbeque', 'kategori' => 'Protein Hewani', 'harga' => 3000],
            ['nama' => 'Telur Asam Manis', 'kategori' => 'Protein Hewani', 'harga' => 3000],
            ['nama' => 'Scramble Egg', 'kategori' => 'Protein Hewani', 'harga' => 2500],
            ['nama' => 'Telur Balado', 'kategori' => 'Protein Hewani', 'harga' => 3000],
            ['nama' => 'Telur Ceplok Bolognese', 'kategori' => 'Protein Hewani', 'harga' => 3000],
            ['nama' => 'Telur Asin', 'kategori' => 'Protein Hewani', 'harga' => 4000],
            ['nama' => 'Telur Puyuh Rebus', 'kategori' => 'Protein Hewani', 'harga' => 2500],
            ['nama' => 'Telur Puyuh Kecap', 'kategori' => 'Protein Hewani', 'harga' => 3000],
            ['nama' => 'Bakso Saos Tiram', 'kategori' => 'Protein Hewani', 'harga' => 3000],

            // PROTEIN NABATI
            ['nama' => 'Tempe Garit', 'kategori' => 'Protein Nabati', 'harga' => 1000],
            ['nama' => 'Kering Tempe', 'kategori' => 'Protein Nabati', 'harga' => 1200],
            ['nama' => 'Tempe Krispi', 'kategori' => 'Protein Nabati', 'harga' => 1200],
            ['nama' => 'Tahu', 'kategori' => 'Protein Nabati', 'harga' => 1000],
            ['nama' => 'Tahu Krispi', 'kategori' => 'Protein Nabati', 'harga' => 1200],
            ['nama' => 'Edamame', 'kategori' => 'Protein Nabati', 'harga' => 1500],
            ['nama' => 'Kacang Merah', 'kategori' => 'Protein Nabati', 'harga' => 1500],
            ['nama' => 'Kacang Polong', 'kategori' => 'Protein Nabati', 'harga' => 1200],
            ['nama' => 'Kacang Kapri', 'kategori' => 'Protein Nabati', 'harga' => 1000],
            ['nama' => 'Kacang Hijau', 'kategori' => 'Protein Nabati', 'harga' => 1300],

            // SAYUR
            ['nama' => 'Mix Vegetable', 'kategori' => 'Sayur', 'harga' => 1700],
            ['nama' => 'Pakcoy', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Bayam', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Sawi Hijau', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Sawi Putih', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Brokoli', 'kategori' => 'Sayur', 'harga' => 800],
            ['nama' => 'Kembang Kol', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Kubis', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Jamur', 'kategori' => 'Sayur', 'harga' => 600],
            ['nama' => 'Rumput Laut', 'kategori' => 'Sayur', 'harga' => 600],
            ['nama' => 'Selada', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Kemangi', 'kategori' => 'Sayur', 'harga' => 400],
            ['nama' => 'Tomat', 'kategori' => 'Sayur', 'harga' => 400],
            ['nama' => 'Timun', 'kategori' => 'Sayur', 'harga' => 400],
            ['nama' => 'Daun Singkong', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Tauge', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Kol Ungu', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Kacang Panjang', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Buncis', 'kategori' => 'Sayur', 'harga' => 500],
            ['nama' => 'Wortel', 'kategori' => 'Sayur', 'harga' => 500],

            // BUAH
            ['nama' => 'Semangka', 'kategori' => 'Buah', 'harga' => 1200],
            ['nama' => 'Melon', 'kategori' => 'Buah', 'harga' => 1400],
            ['nama' => 'Buah Naga', 'kategori' => 'Buah', 'harga' => 1700],
            ['nama' => 'Apel Candy', 'kategori' => 'Buah', 'harga' => 3000],
            ['nama' => 'Apel Fuji', 'kategori' => 'Buah', 'harga' => 4000],
            ['nama' => 'Apel Hijau', 'kategori' => 'Buah', 'harga' => 2000],
            ['nama' => 'Jeruk Medan', 'kategori' => 'Buah', 'harga' => 2800],
            ['nama' => 'Jeruk Santang', 'kategori' => 'Buah', 'harga' => 3000],
            ['nama' => 'Jeruk Baby', 'kategori' => 'Buah', 'harga' => 2300],
            ['nama' => 'Pear', 'kategori' => 'Buah', 'harga' => 4200],
            ['nama' => 'Jambu Kristal', 'kategori' => 'Buah', 'harga' => 3000],
            ['nama' => 'Pisang Ambon', 'kategori' => 'Buah', 'harga' => 2400],
            ['nama' => 'Pisang Raja', 'kategori' => 'Buah', 'harga' => 2400],
            ['nama' => 'Pisang Kapasan', 'kategori' => 'Buah', 'harga' => 1000],
            ['nama' => 'Belimbing', 'kategori' => 'Buah', 'harga' => 3000],
            ['nama' => 'Anggur Merah', 'kategori' => 'Buah', 'harga' => 4000],
            ['nama' => 'Anggur Muscat', 'kategori' => 'Buah', 'harga' => 4500],
            ['nama' => 'Kelengkeng', 'kategori' => 'Buah', 'harga' => 4000],
            ['nama' => 'Manggis', 'kategori' => 'Buah', 'harga' => 2500],
            ['nama' => 'Mangga', 'kategori' => 'Buah', 'harga' => 3000],
            ['nama' => 'Strawberry', 'kategori' => 'Buah', 'harga' => 2000],
            ['nama' => 'Kurma', 'kategori' => 'Buah', 'harga' => 2000],
            ['nama' => 'Rambutan', 'kategori' => 'Buah', 'harga' => 1500],
            ['nama' => 'Kiwi', 'kategori' => 'Buah', 'harga' => 2000],
            ['nama' => 'Alpukat', 'kategori' => 'Buah', 'harga' => 2000],
        ];

        // Kosongkan tabel dulu jika ada data sebelumnya (Opsional, agar tidak dobel)
        MenuItem::truncate();

        foreach ($menus as $menu) {
            MenuItem::create($menu);
        }
    }
}
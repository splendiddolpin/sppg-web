<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoScanAkgInstagram extends Command
{
    protected $signature = 'sppg:autoscan-akg';
    protected $description = 'Mengambil gambar postingan IG dari halaman welcome, membaca AKG via AI, dan update database';

    public function handle()
    {
        $this->info("Memulai proses pemindaian dari halaman welcome...");

        try {
            // 1. Kunjungi halaman utama (welcome page) lokal/online Anda
            // Sesuaikan URL jika project Anda menggunakan domain lokal lain (misal: http://sppg-web.test)
            $responsePage = Http::get('http://127.0.0.1:8000'); 
            
            if (!$responsePage->successful()) {
                $this->error("Gagal mengakses halaman website.");
                return;
            }

            $htmlContent = $responsePage->body();

            // 2. Gunakan Regex sederhana untuk mencari tautan gambar postingan Instagram di dalam HTML halaman
            // Biasanya widget SociableKit / IG memuat format gambar CDN seperti scontent ataucdninstagram
            preg_match('/https:\/\/[^\s<>"]+\.(jpg|jpeg|png)(\?[^\s<>"]*)?/i', $htmlContent, $matches);
            
            // Atau jika ingin mencari URL gambar spesifik yang mengandung domain instagram cdn:
            // (Kita cari pola gambar yang biasa dipakai IG)
            $latestImageUrl = null;
            if (preg_match_all('/https:\/\/[a-zA-Z0-9-_\/\.:]+\.(jpg|jpeg|png)/i', $htmlContent, $allImages)) {
                // Saring gambar yang berasal dari CDN Instagram/Facebook/SociableKit
                foreach ($allImages[0] as $imgUrl) {
                    if (str_contains($imgUrl, 'fbcdn') || str_contains($imgUrl, 'instagram') || str_contains($imgUrl, 'sociablekit')) {
                        $latestImageUrl = $imgUrl;
                        break;
                    }
                }
            }

            // Fallback: Jika tidak ketemu filter khusus, ambil gambar pertama yang valid di halaman welcome
            if (!$latestImageUrl && !empty($matches[0])) {
                $latestImageUrl = $matches[0];
            }

            if (!$latestImageUrl) {
                $this->error("Tidak ada gambar Instagram/Widget yang terdeteksi di halaman welcome.");
                return;
            }

            $this->info("Gambar IG ditemukan: " . $latestImageUrl);
            $this->info("Mendownload dan mengirim gambar ke Google Gemini AI...");

            // 3. Download Gambar & Ubah ke Base64
            $imageContent = @file_get_contents($latestImageUrl);
            if (!$imageContent) {
                $this->error("Gagal mendownload file gambar dari URL tersebut.");
                return;
            }
            $base64Image = base64_encode($imageContent);

            // 4. Kirim ke Google Gemini AI
            $apiKey = env('GEMINI_API_KEY');
            if (empty($apiKey)) {
                $this->error("API Key Google Gemini belum diatur di file .env!");
                return;
            }

            $prompt = "Kamu adalah sistem ekstraksi data gizi. Baca gambar ini dan temukan angka untuk Energi, Karbohidrat, Protein, Lemak, dan Serat. Kembalikan HANYA format JSON murni: {\"energi\": 250, \"karbohidrat\": 40, \"protein\": 15, \"lemak\": 5, \"serat\": 3}. Jika ada data yang tidak ditemukan, beri nilai 0.";

            $responseAI = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        ['parts' => [
                            ['text' => $prompt],
                            ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => $base64Image]]
                        ]]
                    ]
                ]);

            if ($responseAI->successful()) {
                $result = $responseAI->json();
                $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
                $aiText = str_replace(['```json', '```'], '', $aiText);
                
                $gizi = json_decode(trim($aiText), true);

                if (isset($gizi['energi'])) {
                    // Simpan ke database (Sesuaikan nama tabel Anda, asumsikan tabel_akg / atau update kolom terkait)
                    // Jika data AKG disimpan di tabel khusus, sesuaikan query di bawah:
                    DB::table('tabel_akg')->where('id', 1)->update([
                        'energi' => $gizi['energi'],
                        'karbohidrat' => $gizi['karbohidrat'],
                        'protein' => $gizi['protein'],
                        'lemak' => $gizi['lemak'],
                        'serat' => $gizi['serat'],
                        'updated_at' => now(),
                    ]);

                    $this->info("SUKSES BESAR! Nilai AKG berhasil diperbarui otomatis dari Welcome Page.");
                    Log::info("Auto-Scan Welcome Page BERHASIL.");
                } else {
                    $this->error("AI merespon, tetapi format data gizi tidak valid.");
                }
            } else {
                $this->error("Gagal terhubung ke API Google Gemini.");
            }

        } catch (\Exception $e) {
            $this->error("Terjadi kesalahan sistem: " . $e->getMessage());
        }
    }
}
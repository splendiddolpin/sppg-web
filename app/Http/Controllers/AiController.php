<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function scanAkg(Request $request)     {         // 1. Validasi gambar yang diupload$request->validate([
            'image' => 'required|image|max:4096', // Max 4MB
        ]);

        // 2. Ubah gambar menjadi Base64 agar bisa dikirim ke Google Gemini
        $image =$request->file('image');
        $base64Image = base64_encode(file_get_contents($image->getPathname()));
        $mimeType =$image->getMimeType();

        // 3. API Key Gemini (Dapatkan gratis di Google AI Studio, lalu taruh di .env Anda: GEMINI_API_KEY=xxx)
        $apiKey = env('GEMINI_API_KEY'); 

        // 4. Prompt / Perintah untuk AI (Sangat Spesifik agar tidak meleset)
        $prompt = "Kamu adalah sistem ekstraksi data gizi. Baca gambar ini dan temukan angka untuk Energi (Kalori), Karbohidrat, Protein, Lemak, dan Serat. Kembalikan HANYA dalam format JSON murni yang valid tanpa teks markdown, tanpa backticks, dan tanpa penjelasan apapun. Contoh format wajib: {\"energi\": 250, \"karbohidrat\": 40, \"protein\": 15, \"lemak\": 5, \"serat\": 3}. Jika ada data yang tidak ditemukan, beri nilai 0.";

        // 5. Tembak ke API Google Gemini 1.5 Flash (Sangat Cepat & Gratis)
        $response = Http::withHeaders([             'Content-Type' => 'application/json',         ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $base64Image
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        // 6. Ambil hasil JSON dan kirim kembali ke Frontend
        if ($response->successful()) {
            $result =$response->json();
            $aiText =$result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
            
            // Bersihkan sisa-sisa markdown backticks (```json) jika AI bandel
            $aiText = str_replace(['```json', '```'], '', $aiText);
            
            return response()->json(json_decode(trim($aiText), true));
        }

        return response()->json(['error' => 'Gagal membaca gambar dengan AI.'], 500);
    }
}
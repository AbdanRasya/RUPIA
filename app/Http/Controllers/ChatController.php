<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $pesanUser = $request->input('message');
        
        $apiKey = config('app.gemini_key', env('GEMINI_API_KEY'));

        if (!$apiKey) {
            return response()->json([
                'reply' => 'Error: API Key Gemini belum terbaca di sistem Laravel kamu.'
            ]);
        }

        // Panggil API menggunakan model terbaru yang aktif saat ini: gemini-2.5-flash
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Kamu adalah asisten keuangan AI bernama Rupia AI. Jawab dengan sangat singkat, ramah, dan profesional. Pertanyaan user: " . $pesanUser]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $balasanAI = $response->json('candidates.0.content.parts.0.text');
            $balasanAI = str_replace(['**', '*'], '', $balasanAI); 
        } else {
            // Memunculkan pesan error asli dari Google jika masih ada kendala
            $errorDetail = $response->json('error.message') ?? 'Koneksi gagal';
            $balasanAI = "Waduh, ada kendala sistem: " . $errorDetail;
        }

        return response()->json([
            'reply' => $balasanAI
        ]);
    }
}
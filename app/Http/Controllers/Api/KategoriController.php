<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori; // Import model yang tadi kita bikin
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Fungsi untuk mengambil semua data kategori
    public function index()
    {
        $kategori = Kategori::all();

        // Juknis tugas minta format JSON, ini kodenya:
        return response()->json([
            'status' => 'success',
            'message' => 'Data Kategori Berhasil Diambil',
            'data' => $kategori
        ], 200);
    }
}
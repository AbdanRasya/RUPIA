<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saving;

class SavingApiController extends Controller
{
    // GET: Ambil semua data tabungan
    public function index()
    {
        // Untuk API, kita ambil semua data dulu
        $savings = Saving::all(); 
        
        return response()->json([
            'message' => 'Berhasil mengambil data tabungan',
            'data' => $savings
        ], 200);
    }

    // POST: Bikin tabungan baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer', // Di API, minta user_id diinput manual
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1000',
        ]);

        $saving = Saving::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'current_amount' => 0
        ]);

        return response()->json([
            'message' => 'Target tabungan berhasil dibuat!',
            'data' => $saving
        ], 201);
    }

    // GET: Ambil detail 1 tabungan
    public function show($id)
    {
        $saving = Saving::find($id);
        
        if(!$saving) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail tabungan',
            'data' => $saving
        ], 200);
    }

    // PUT: Update isi celengan lewat API
    public function update(Request $request, $id)
    {
        $saving = Saving::find($id);
        
        if(!$saving) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate(['amount' => 'required|numeric|min:500']);
        
        // Langsung tambah uangnya untuk versi API
        $saving->increment('current_amount', $request->amount);

        return response()->json([
            'message' => 'Uang berhasil ditambahkan ke celengan!',
            'data' => $saving
        ], 200);
    }

    // DELETE: Hapus tabungan
    public function destroy($id)
    {
        $saving = Saving::find($id);
        
        if(!$saving) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $saving->delete();

        return response()->json(['message' => 'Tabungan berhasil dihapus'], 200);
    }
}
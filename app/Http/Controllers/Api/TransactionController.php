<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // 1. GET ALL TRANSACTIONS (Melihat semua data)
    public function index()
    {
        $data = Transaction::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Transaksi Rupia',
            'data'    => $data
        ], 200);
    }

    // 2. CREATE TRANSACTION (Tambah data via API)
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'amount'   => 'required|numeric|min:500',
            'category' => 'required|string',
            'mood'     => 'required|string',
            'type'     => 'required|in:income,expense',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Simpan data
        $transaction = Transaction::create([
            'user_id'        => 1, // Sementara di-hardcode ke ID 1 untuk testing
            'type'           => $request->type,
            'amount'         => $request->amount,
            'category'       => $request->category,
            'mood'           => $request->mood,
            'description'    => $request->description,
            'status'         => 'success',
            'payment_method' => 'cash'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi Berhasil Dicatat!',
            'data'    => $transaction
        ], 201);
    }

    // 3. SHOW DETAIL (Melihat 1 data spesifik)
    public function show($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            return response()->json(['success' => true, 'data' => $transaction], 200);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    // 4. DELETE (Hapus data)
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            $transaction->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Data gagal dihapus'], 404);
    }
}
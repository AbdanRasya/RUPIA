<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function index()
    {
        return view('topup.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required'
        ]);

        // Simpan ke tabel transactions sebagai 'income'
        Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'income',
            'category' => 'Topup',
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'success', // Kita set success dulu untuk simulasi tanpa Midtrans
            'description' => 'Top Up Saldo via ' . strtoupper($request->payment_method),
            'mood' => 'Happy'
        ]);

        return redirect('/')->with('success', 'Top Up berhasil! Saldo kamu bertambah.');
    }
}
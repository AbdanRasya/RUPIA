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

        // Simpan ke tabel transactions sebagai 'income' (Disederhanakan)
        $transaksiBaru = new Transaction();
        $transaksiBaru->user_id = Auth::id();
        $transaksiBaru->type = 'income';
        $transaksiBaru->category = 'Pemasukan';
        $transaksiBaru->amount = $request->amount;
        $transaksiBaru->payment_method = $request->payment_method;
        $transaksiBaru->status = 'success';
        $transaksiBaru->description = 'Catat Pemasukan via ' . strtoupper($request->payment_method);
        $transaksiBaru->mood = 'Happy';
        $transaksiBaru->save();

        return redirect('/')->with('success', 'Top Up berhasil! Saldo kamu bertambah.');
    }
}
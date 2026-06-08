<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->where('type', 'income')->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('topup.index', compact('categories', 'wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date'
        ]);

        $userId = Auth::id();
        $wallet = Wallet::where('id', $request->wallet_id)->where('user_id', $userId)->firstOrFail();
        $category = Category::where('id', $request->category_id)->where('user_id', $userId)->firstOrFail();

        // Simpan ke tabel transactions
        Transaction::create([
            'user_id' => $userId,
            'wallet_id' => $wallet->id,
            'type' => 'income',
            'amount' => $request->amount,
            'category' => $category->name,
            'mood' => 'Happy',
            'description' => $request->description ?: 'Pemasukan ' . $category->name,
            'status' => 'success',
            'payment_method' => $wallet->type,
            'transaction_date' => $request->transaction_date
        ]);

        // Tambah saldo wallet
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect('/')->with('success', 'Pemasukan berhasil dicatat! Saldo ' . $wallet->name . ' bertambah.');
    }
}
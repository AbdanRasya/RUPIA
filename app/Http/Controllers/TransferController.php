<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('transfer.index', compact('wallets'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'source_wallet_id' => 'required|exists:wallets,id',
            'destination_wallet_id' => 'required|exists:wallets,id|different:source_wallet_id',
            'amount' => 'required|numeric|min:1000',
            'notes' => 'nullable|string'
        ]);

        $userId = Auth::id();
        $sourceWallet = Wallet::where('id', $request->source_wallet_id)->where('user_id', $userId)->firstOrFail();
        $destWallet = Wallet::where('id', $request->destination_wallet_id)->where('user_id', $userId)->firstOrFail();

        // 1. Cek Saldo
        if ($request->amount > $sourceWallet->balance) {
            return redirect()->back()->with('error', 'Saldo ' . $sourceWallet->name . ' tidak cukup. Sisa: Rp ' . number_format($sourceWallet->balance, 0, ',', '.'));
        }

        // 2. Catat Transfer sebagai Expense di dompet asal
        Transaction::create([
            'user_id' => $userId,
            'wallet_id' => $sourceWallet->id,
            'reference_wallet_id' => $destWallet->id,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => 'Transfer',
            'mood' => 'Normal',
            'description' => 'Transfer ke ' . $destWallet->name . ($request->notes ? ' (' . $request->notes . ')' : ''),
            'status' => 'success',
            'payment_method' => $sourceWallet->type,
            'transaction_date' => now()
        ]);
        
        // 3. Catat Transfer sebagai Income di dompet tujuan
        Transaction::create([
            'user_id' => $userId,
            'wallet_id' => $destWallet->id,
            'reference_wallet_id' => $sourceWallet->id,
            'type' => 'income',
            'amount' => $request->amount,
            'category' => 'Transfer',
            'mood' => 'Normal',
            'description' => 'Transfer dari ' . $sourceWallet->name,
            'status' => 'success',
            'payment_method' => $destWallet->type,
            'transaction_date' => now()
        ]);

        // 4. Update balance
        $sourceWallet->balance -= $request->amount;
        $sourceWallet->save();
        
        $destWallet->balance += $request->amount;
        $destWallet->save();

        return redirect('/transfer')->with('success', 'Transfer Rp ' . number_format($request->amount, 0, ',', '.') . ' ke ' . $destWallet->name . ' berhasil! 💸');
    }
}
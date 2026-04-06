<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create()
    {
        return view('transaction.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'category' => 'required|string',
            'mood' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $userId = Auth::id();

        // 1. CEK SALDO SAAT INI
        $income = Transaction::where('user_id', $userId)->where('type', 'income')->where('status', 'success')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->where('status', 'success')->sum('amount');
        $currentBalance = $income - $expense;

        // 2. BLOKIR JIKA SALDO TIDAK CUKUP
        if ($request->amount > $currentBalance) {
            return redirect()->back()->with('error', 'Waduh! Saldo kamu tidak cukup. Sisa saldomu cuma Rp ' . number_format($currentBalance, 0, ',', '.'));
        }

        // 3. JIKA SALDO CUKUP, CATAT PENGELUARAN
        Transaction::create([
            'user_id' => $userId,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => $request->category,
            'mood' => $request->mood,
            'description' => $request->description,
            'status' => 'success',
            'payment_method' => 'cash'
        ]);

        return redirect('/')->with('success', 'Pengeluaran berhasil dicatat! Uangmu berkurang.');
    }
}
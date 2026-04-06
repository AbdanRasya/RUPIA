<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index()
    {
        return view('transfer.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'amount' => 'required|numeric|min:10000',
            'notes' => 'nullable|string'
        ]);

        $userId = Auth::id();

        // 1. Cek Saldo
        $income = Transaction::where('user_id', $userId)->where('type', 'income')->where('status', 'success')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->where('status', 'success')->sum('amount');
        $currentBalance = $income - $expense;

        // 2. Tolak jika miskin saldo wkwk
        if ($request->amount > $currentBalance) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk transfer. Sisa saldo: Rp ' . number_format($currentBalance, 0, ',', '.'));
        }

        // 3. Catat Transfer
        Transaction::create([
            'user_id' => $userId,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => 'Transfer',
            'mood' => 'Normal',
            'description' => 'Transfer ke ' . $request->destination . ' (' . $request->notes . ')',
            'status' => 'success',
            'payment_method' => 'Rupia Balance'
        ]);

        return redirect('/transfer')->with('success', 'Transfer Rp ' . number_format($request->amount, 0, ',', '.') . ' ke ' . $request->destination . ' berhasil cuy! 💸');
    }
}
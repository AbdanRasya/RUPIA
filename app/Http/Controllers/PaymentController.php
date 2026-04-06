<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Menampilkan halaman pembayaran
    public function index()
    {
        return view('payment.index');
    }

    // Memproses simulasi pembayaran
    public function process(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'amount' => 'required|numeric|min:1000'
        ]);

        $userId = Auth::id();

        // 1. Cek Saldo Real-Time
        $income = Transaction::where('user_id', $userId)->where('type', 'income')->where('status', 'success')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->where('status', 'success')->sum('amount');
        $currentBalance = $income - $expense;

        // 2. Tolak jika saldo tidak cukup
        if ($request->amount > $currentBalance) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk membeli ' . $request->product_name . '. Sisa saldo: Rp ' . number_format($currentBalance, 0, ',', '.'));
        }

        // 3. Catat sebagai pengeluaran (Kategori: Bills)
        Transaction::create([
            'user_id' => $userId,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => 'Bills',
            'mood' => 'Happy', // Anggap aja beli kebutuhan itu bikin happy
            'description' => 'Pembayaran: ' . $request->product_name,
            'status' => 'success',
            'payment_method' => 'Rupia Balance'
        ]);

        return redirect('/pay')->with('success', 'Hore! Pembelian ' . $request->product_name . ' berhasil. Saldo otomatis dipotong.');
    }
}
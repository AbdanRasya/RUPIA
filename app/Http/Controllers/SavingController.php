<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SavingController extends Controller
{
    public function index()
    {
        $savings = Saving::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('saving.index', compact('savings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1000',
        ]);

        Saving::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'current_amount' => 0
        ]);

        return redirect('/saving')->with('success', 'Target tabungan berhasil dibuat!');
    }

    public function addDeposit(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:500']);
        $userId = Auth::id();
        
        // 1. CEK SALDO SAAT INI
        $income = Transaction::where('user_id', $userId)->where('type', 'income')->where('status', 'success')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->where('status', 'success')->sum('amount');
        $currentBalance = $income - $expense;

        // 2. BLOKIR JIKA SALDO TIDAK CUKUP
        if ($request->amount > $currentBalance) {
            return redirect()->back()->with('error', 'Oops! Saldo utama kamu tidak cukup untuk isi celengan.');
        }

        // 3. JIKA SALDO CUKUP, LANJUTKAN PROSES NABUNG
        $saving = Saving::where('id', $id)->where('user_id', $userId)->first();
        if (!$saving) {
            return redirect()->back()->with('error', 'Tabungan tidak ditemukan.');
        }

        // Tambah saldo tabungan
        $saving->current_amount = $saving->current_amount + $request->amount;
        $saving->save();

        // Catat sebagai pengeluaran di tabel transaksi
        $transaksiBaru = new Transaction();
        $transaksiBaru->user_id = $userId;
        $transaksiBaru->type = 'expense';
        $transaksiBaru->category = 'Saving';
        $transaksiBaru->amount = $request->amount;
        $transaksiBaru->description = 'Isi celengan: ' . $saving->title;
        $transaksiBaru->status = 'success';
        $transaksiBaru->mood = 'Happy';
        $transaksiBaru->save();

        return redirect('/saving')->with('success', 'Uang berhasil masuk celengan! 💰');
    }
}
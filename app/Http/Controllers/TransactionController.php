<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->where('type', 'expense')->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('transaction.create', compact('categories', 'wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'mood' => 'required|string',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $userId = Auth::id();
        $wallet = Wallet::where('id', $request->wallet_id)->where('user_id', $userId)->firstOrFail();
        $category = Category::where('id', $request->category_id)->where('user_id', $userId)->firstOrFail();

        // BLOKIR JIKA SALDO TIDAK CUKUP
        if ($request->amount > $wallet->balance) {
            return redirect()->back()->with('error', 'Waduh! Saldo di dompet ' . $wallet->name . ' tidak cukup. Sisa: Rp ' . number_format($wallet->balance, 0, ',', '.'));
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/transactions'), $filename);
            $attachmentPath = 'uploads/transactions/' . $filename;
        }

        // CATAT PENGELUARAN
        Transaction::create([
            'user_id' => $userId,
            'wallet_id' => $wallet->id,
            'type' => 'expense',
            'amount' => $request->amount,
            'category' => $category->name,
            'mood' => $request->mood,
            'description' => $request->description,
            'status' => 'success',
            'payment_method' => $wallet->type,
            'transaction_date' => $request->transaction_date,
            'attachment' => $attachmentPath
        ]);

        // Kurangi saldo wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        return redirect('/')->with('success', 'Pengeluaran berhasil dicatat! Saldo ' . $wallet->name . ' berkurang.');
    }
}
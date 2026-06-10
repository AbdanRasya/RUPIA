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
        $userId = Auth::id();
        $categories = Category::where('user_id', $userId)->where('type', 'income')->get();
        $wallets = Wallet::where('user_id', $userId)->get();

        if ($wallets->isEmpty()) {
            $newWallet = Wallet::create([
                'user_id' => $userId,
                'name' => 'Dompet Utama',
                'type' => 'cash',
                'balance' => 0,
                'icon' => '👛'
            ]);
            $wallets->push($newWallet);
        }

        if ($categories->isEmpty()) {
            $defaultCategories = [
                ['name' => 'Gaji', 'type' => 'income', 'icon' => '💰'],
                ['name' => 'Uang Jajan', 'type' => 'income', 'icon' => '💵'],
            ];
            foreach ($defaultCategories as $cat) {
                $newCat = Category::create([
                    'user_id' => $userId,
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                    'icon' => $cat['icon']
                ]);
                $categories->push($newCat);
            }
        }

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

        return redirect('/dashboard')->with('success', 'Pemasukan berhasil dicatat! Saldo ' . $wallet->name . ' bertambah.');
    }
}
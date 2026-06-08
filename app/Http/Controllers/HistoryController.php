<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())->with(['wallet', 'referenceWallet']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            // Kita masih menyimpan category name di tabel transaction saat ini (berdasarkan migrasi lama).
            // Kalau migrasi lama tidak diubah, category_id dicari via nama.
            $category = Category::find($request->category_id);
            if ($category) {
                $query->where('category', $category->name);
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->paginate(15);
                              
        $categories = Category::where('user_id', Auth::id())->get();
        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('history.index', compact('transactions', 'categories', 'wallets'));
    }
}

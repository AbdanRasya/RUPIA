<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $budgets = Budget::with('category')->where('user_id', $userId)->get();
        $categories = Category::where('user_id', $userId)->where('type', 'expense')->get();

        // Jika user belum punya kategori pengeluaran, buatkan default
        if ($categories->isEmpty()) {
            $defaultCategories = [
                ['name' => 'Makan & Minum', 'type' => 'expense', 'icon' => '🍔'],
                ['name' => 'Transportasi', 'type' => 'expense', 'icon' => '🚗'],
                ['name' => 'Belanja', 'type' => 'expense', 'icon' => '🛍️'],
                ['name' => 'Tagihan & Utilitas', 'type' => 'expense', 'icon' => '🧾'],
                ['name' => 'Hiburan', 'type' => 'expense', 'icon' => '🎬'],
                ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => '🏥'],
                ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => '📚'],
            ];

            foreach ($defaultCategories as $cat) {
                Category::create([
                    'user_id' => $userId,
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                    'icon' => $cat['icon']
                ]);
            }
            $categories = Category::where('user_id', $userId)->where('type', 'expense')->get();
        }

        // Hitung pengeluaran per budget
        foreach ($budgets as $budget) {
            $spent = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->where('category', optional($budget->category)->name)
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('amount');
                
            $budget->spent = $spent;
        }

        return view('budgets.index', compact('budgets', 'categories', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1000'
        ]);

        // Cek apakah sudah ada budget untuk kategori ini
        $existing = Budget::where('user_id', Auth::id())->where('category_id', $request->category_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Budget untuk kategori ini sudah ada!');
        }

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'period' => 'monthly',
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year
        ]);

        return redirect()->back()->with('success', 'Budget berhasil dibuat!');
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);

        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        $budget->update(['amount' => $request->amount]);

        return redirect()->back()->with('success', 'Budget berhasil diupdate!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);
        $budget->delete();
        return redirect()->back()->with('success', 'Budget berhasil dihapus!');
    }
}

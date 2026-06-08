<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // 1. Pengeluaran Terbesar Bulan Ini
        $biggestExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->orderBy('amount', 'desc')
            ->first();

        // 2. Kategori Paling Boros
        $categoryStats = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();
            
        $mostExpensiveCategory = $categoryStats->first();

        // 3. Perbandingan Bulan Ini vs Bulan Lalu (Khusus Pengeluaran)
        $currentMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');
            
        $lastMonth = Carbon::create($year, $month, 1)->subMonth();
        $lastMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->sum('amount');

        $expenseDiff = $currentMonthExpense - $lastMonthExpense;
        $expenseDiffPercentage = $lastMonthExpense > 0 ? ($expenseDiff / $lastMonthExpense) * 100 : 0;

        // Data for Chart
        $chartLabels = $categoryStats->pluck('category')->toArray();
        $chartData = $categoryStats->pluck('total')->toArray();

        return view('statistik.index', compact(
            'month', 'year', 
            'biggestExpense', 
            'mostExpensiveCategory', 
            'currentMonthExpense', 
            'lastMonthExpense', 
            'expenseDiff', 
            'expenseDiffPercentage',
            'chartLabels',
            'chartData'
        ));
    }
}

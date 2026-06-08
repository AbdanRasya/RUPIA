<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Saldo Real Time dari Wallets
        $totalBalance = Wallet::where('user_id', $userId)->sum('balance');

        // 2. Income & Expense Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $expense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Financial Health Score (0-100)
        // Logika sederhana: 
        // 50 poin default, +20 jika income > expense, +10 jika ada wallet dengan saldo > 1jt
        $healthScore = 50;
        if ($income > $expense && $income > 0) $healthScore += 30;
        if ($totalBalance > 1000000) $healthScore += 20;

        // 4. Data Grafik Arus Kas 7 Hari Terakhir
        $labels = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d M');
            
            $incomeData[] = Transaction::where('user_id', $userId)->where('type', 'income')->whereDate('transaction_date', $date)->sum('amount');
            $expenseData[] = Transaction::where('user_id', $userId)->where('type', 'expense')->whereDate('transaction_date', $date)->sum('amount');
        }

        // 5. Transaksi Terakhir
        $recentTransactions = Transaction::where('user_id', $userId)->with('wallet')->orderBy('transaction_date', 'desc')->orderBy('created_at', 'desc')->limit(5)->get();

        // 6. Data API (Berita & Crypto)
        $usdToIdr = 15500;
        $btcToIdr = 1000000000;
        $newsList = [];
        try {
            $usdResponse = Http::timeout(3)->get('https://api.exchangerate-api.com/v4/latest/USD');
            if($usdResponse->successful()) $usdToIdr = $usdResponse->json('rates.IDR');
            
            $btcResponse = Http::timeout(3)->get('https://indodax.com/api/btc_idr/ticker');
            if($btcResponse->successful()) $btcToIdr = $btcResponse->json('ticker.last');
            
            // Gunakan endpoint yang lebih stabil
            $newsResponse = Http::timeout(4)->get('https://api-berita-indonesia.vercel.app/cnbc/terbaru/');
            if ($newsResponse->successful()) {
                $newsList = array_slice($newsResponse->json('data.posts') ?? [], 0, 3);
            }
        } catch (\Exception $e) {
            // Biarkan fallback bekerja
        }

        return view('index', compact('totalBalance', 'income', 'expense', 'healthScore', 'labels', 'incomeData', 'expenseData', 'recentTransactions', 'usdToIdr', 'btcToIdr', 'newsList'));
    }
    public function toggleAntiImpulse(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            $user->is_anti_impulse_active = $request->boolean('is_active');
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'is_active' => $user ? $user->is_anti_impulse_active : false,
            'message' => ($user && $user->is_anti_impulse_active) ? 'Mode Anti-Impuls Diaktifkan!' : 'Mode Anti-Impuls Dimatikan!'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung Saldo Real Time
        $income = Transaction::where('user_id', $userId)->where('type', 'income')->where('status', 'success')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->where('status', 'success')->sum('amount');
        $totalBalance = $income - $expense;

        // 2. Data Grafik Mood (Disederhanakan untuk pemula)
        $expenses = Transaction::where('user_id', $userId)->where('type', 'expense')->get();
        
        $chartData = [
            'Happy' => 0,
            'Stress' => 0,
            'Bored' => 0,
            'FOMO' => 0
        ];

        foreach ($expenses as $expenseItem) {
            if (isset($chartData[$expenseItem->mood])) {
                $chartData[$expenseItem->mood] = $chartData[$expenseItem->mood] + $expenseItem->amount;
            }
        }

        // 3. API Data Market
        try {
            $usdResponse = Http::timeout(3)->get('https://api.exchangerate-api.com/v4/latest/USD');
            $usdToIdr = $usdResponse->json('rates.IDR') ?? 15500;
        } catch (\Exception $e) {
            $usdToIdr = 15500;
        }

        try {
            $btcResponse = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->timeout(3)->get('https://indodax.com/api/btc_idr/ticker');
            $btcToIdr = $btcResponse->json('ticker.last') ?? 1000000000;

            $goldResponse = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->timeout(3)->get('https://indodax.com/api/xaur_idr/ticker');
            $goldPrice = $goldResponse->json('ticker.last') ?? 1450000;
        } catch (\Exception $e) {
            $btcToIdr = 1000000000;
            $goldPrice = 1450000;
        }
        
        // 4. API Berita (Waktu tunggu dinaikkan jadi 5 detik)
        $newsList = [];
        try {
            $newsResponse = Http::timeout(5)->get('https://api-berita-indonesia.vercel.app/cnbc/market/');
            if ($newsResponse->successful()) {
                $newsList = array_slice($newsResponse->json('data.posts') ?? [], 0, 3);
            }
        } catch (\Exception $e) {
            $newsList = [];
        }

        return view('index', compact('totalBalance', 'income', 'expense', 'chartData', 'usdToIdr', 'btcToIdr', 'goldPrice', 'newsList'));
    }
}
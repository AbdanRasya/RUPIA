<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        // Akan merender view kalender
        // FullCalendar akan memanggil endpoint API untuk mendapatkan data events (transaksi)
        return view('calendar.index');
    }

    public function events(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$start, $end])
            ->get();

        $events = [];
        foreach ($transactions as $trx) {
            $events[] = [
                'title' => ($trx->type == 'income' ? '+' : '-') . ' Rp ' . number_format($trx->amount, 0, ',', '.'),
                'start' => $trx->transaction_date,
                'color' => $trx->type == 'income' ? '#10B981' : '#EF4444',
                'description' => $trx->description ?: $trx->category,
                'url' => url('/history?search=' . urlencode($trx->description ?: $trx->category)) // klik ke history
            ];
        }

        return response()->json($events);
    }
}

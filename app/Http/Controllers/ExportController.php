<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Saving;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function downloadCsv()
    {
        $transactions = Transaction::where('user_id', Auth::id())->with('wallet')->orderBy('transaction_date', 'asc')->get();
        
        $filename = "rupia_transactions_" . date('Ymd_His') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        fputcsv($handle, ['Tanggal', 'Tipe', 'Kategori', 'Nominal', 'Dompet', 'Catatan']);
        
        foreach ($transactions as $row) {
            fputcsv($handle, [
                $row->transaction_date,
                $row->type,
                $row->category,
                $row->amount,
                $row->wallet ? $row->wallet->name : '',
                $row->description
            ]);
        }
        
        fclose($handle);
        exit;
    }

    public function backupJson()
    {
        $userId = Auth::id();
        $data = [
            'wallets' => Wallet::where('user_id', $userId)->get(),
            'categories' => Category::where('user_id', $userId)->get(),
            'transactions' => Transaction::where('user_id', $userId)->get(),
            'savings' => Saving::where('user_id', $userId)->get(),
            'budgets' => Budget::where('user_id', $userId)->get()
        ];
        
        $filename = "rupia_backup_" . date('Ymd_His') . ".json";
        
        return response()->json($data)->withHeaders([
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}

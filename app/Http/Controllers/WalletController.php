<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:tunai,bank,ewallet',
            'balance' => 'required|numeric'
        ]);

        $icons = ['tunai' => '💵', 'bank' => '🏦', 'ewallet' => '📱'];
        $colors = ['tunai' => '#10B981', 'bank' => '#3B82F6', 'ewallet' => '#34D399'];

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'icon' => $icons[$request->type] ?? '💰',
            'color' => $colors[$request->type] ?? '#64748B'
        ]);

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil ditambahkan');
    }

    public function edit(Wallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) abort(403);
        return view('wallets.edit', compact('wallet'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) abort(403);
        
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:tunai,bank,ewallet',
            'balance' => 'required|numeric'
        ]);

        $icons = ['tunai' => '💵', 'bank' => '🏦', 'ewallet' => '📱'];
        $colors = ['tunai' => '#10B981', 'bank' => '#3B82F6', 'ewallet' => '#34D399'];

        $wallet->update([
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'icon' => $icons[$request->type] ?? '💰',
            'color' => $colors[$request->type] ?? '#64748B'
        ]);

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil diupdate');
    }

    public function destroy(Wallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) abort(403);
        
        // Pastikan tidak menghapus jika ada transaksi
        if (Transaction::where('wallet_id', $wallet->id)->exists() || Transaction::where('reference_wallet_id', $wallet->id)->exists()) {
            return redirect()->route('wallets.index')->with('error', 'Dompet tidak dapat dihapus karena sudah memiliki transaksi terkait.');
        }

        $wallet->delete();
        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dihapus');
    }
}

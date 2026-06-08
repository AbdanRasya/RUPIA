<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
    public function index()
    {
        $savings = Saving::where('user_id', Auth::id())->get();
        return view('saving.index', compact('savings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'target_amount' => 'required|numeric|min:1000',
            'deadline' => 'nullable|date',
            'icon' => 'nullable|string'
        ]);

        Saving::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'current_amount' => 0,
            'deadline' => $request->deadline,
            'icon' => $request->icon ?: '🎯'
        ]);

        return redirect()->back()->with('success', 'Target tabungan berhasil dibuat!');
    }

    public function update(Request $request, Saving $saving)
    {
        if ($saving->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string',
            'target_amount' => 'required|numeric|min:1000',
            'deadline' => 'nullable|date',
            'icon' => 'nullable|string'
        ]);

        $saving->update([
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'icon' => $request->icon ?: '🎯'
        ]);

        return redirect()->back()->with('success', 'Target tabungan berhasil diupdate!');
    }

    public function destroy(Saving $saving)
    {
        if ($saving->user_id !== Auth::id()) abort(403);
        $saving->delete();
        return redirect()->back()->with('success', 'Target tabungan berhasil dihapus!');
    }

    public function topup(Request $request, $id)
    {
        $saving = Saving::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        $saving->current_amount += $request->amount;
        $saving->save();

        return redirect()->back()->with('success', 'Berhasil menabung Rp ' . number_format($request->amount, 0, ',', '.') . ' ke ' . $saving->title);
    }
}
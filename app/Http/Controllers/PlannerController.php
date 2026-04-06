<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class PlannerController extends Controller
{
    // Menampilkan halaman Planner beserta datanya
    public function index()
    {
        $plans = Plan::where('user_id', Auth::id())->orderBy('year', 'asc')->get();
        return view('planner.index', compact('plans'));
    }

    // Menyimpan rencana masa depan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:4',
            'event_name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        Plan::create([
            'user_id' => Auth::id(),
            'year' => $request->year,
            'event_name' => $request->event_name,
            'description' => $request->description
        ]);

        return redirect('/planner')->with('success', 'Rencana masa depan berhasil dicatat!');
    }
}
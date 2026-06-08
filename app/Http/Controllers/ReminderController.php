<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::where('user_id', Auth::id())->orderBy('remind_date', 'asc')->get();
        return view('reminders.index', compact('reminders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'remind_date' => 'required|date',
            'repeat' => 'required|in:none,daily,weekly,monthly'
        ]);

        Reminder::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'remind_date' => $request->remind_date,
            'repeat' => $request->repeat
        ]);

        return redirect()->back()->with('success', 'Reminder berhasil dibuat!');
    }

    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'remind_date' => 'required|date',
            'repeat' => 'required|in:none,daily,weekly,monthly'
        ]);

        $reminder->update([
            'title' => $request->title,
            'description' => $request->description,
            'remind_date' => $request->remind_date,
            'repeat' => $request->repeat
        ]);

        return redirect()->back()->with('success', 'Reminder berhasil diupdate!');
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) abort(403);
        $reminder->delete();
        return redirect()->back()->with('success', 'Reminder berhasil dihapus!');
    }

    public function toggle(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) abort(403);
        $reminder->is_done = !$reminder->is_done;
        $reminder->save();
        return redirect()->back();
    }
}

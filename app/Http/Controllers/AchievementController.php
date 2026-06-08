<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Transaction;
use App\Models\Saving;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $this->checkAchievements($userId);
        
        $achievements = Achievement::where('user_id', $userId)->get();
        return view('achievements.index', compact('achievements'));
    }

    private function checkAchievements($userId)
    {
        $trxCount = Transaction::where('user_id', $userId)->count();
        $savingCompleted = Saving::where('user_id', $userId)->whereColumn('current_amount', '>=', 'target_amount')->count();

        // 1. First Transaction
        if ($trxCount >= 1) {
            $this->award($userId, 'first_blood', 'Langkah Pertama', 'Mencatat transaksi pertama kali di Rupia.');
        }

        // 2. 50 Transactions
        if ($trxCount >= 50) {
            $this->award($userId, 'trx_50', 'Si Rajin Mencatat', 'Mencatat hingga 50 transaksi.');
        }

        // 3. Savings Completed
        if ($savingCompleted >= 1) {
            $this->award($userId, 'saver_1', 'Pencapai Target', 'Berhasil mencapai 1 target tabungan.');
        }
    }

    private function award($userId, $type, $title, $description)
    {
        $exists = Achievement::where('user_id', $userId)->where('type', $type)->exists();
        if (!$exists) {
            Achievement::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'description' => $description,
                'earned_at' => now()
            ]);
        }
    }
}

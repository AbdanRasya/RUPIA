<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;
use App\Models\User;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) return;

        foreach ($users as $user) {
            $wallets = [
                ['name' => 'Tunai', 'type' => 'tunai', 'balance' => 0, 'icon' => '💵', 'color' => '#10B981'],
                ['name' => 'BCA', 'type' => 'bank', 'balance' => 0, 'icon' => '🏦', 'color' => '#3B82F6'],
                ['name' => 'GoPay', 'type' => 'ewallet', 'balance' => 0, 'icon' => '📱', 'color' => '#34D399'],
            ];

            foreach ($wallets as $wallet) {
                Wallet::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $wallet['name']
                ], [
                    'type' => $wallet['type'],
                    'balance' => $wallet['balance'],
                    'icon' => $wallet['icon'],
                    'color' => $wallet['color']
                ]);
            }
        }
    }
}

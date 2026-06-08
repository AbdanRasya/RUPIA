<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) return;

        foreach ($users as $user) {
            $categories = [
                // Expenses
                ['name' => 'Makanan', 'type' => 'expense', 'icon' => '🍔', 'color' => '#F59E0B'],
                ['name' => 'Transportasi', 'type' => 'expense', 'icon' => '🚗', 'color' => '#3B82F6'],
                ['name' => 'Belanja', 'type' => 'expense', 'icon' => '🛍️', 'color' => '#EC4899'],
                ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => '📚', 'color' => '#8B5CF6'],
                ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => '💊', 'color' => '#EF4444'],
                ['name' => 'Hiburan', 'type' => 'expense', 'icon' => '🎮', 'color' => '#14B8A6'],
                ['name' => 'Tagihan', 'type' => 'expense', 'icon' => '📄', 'color' => '#64748B'],
                ['name' => 'Lainnya', 'type' => 'expense', 'icon' => '📦', 'color' => '#94A3B8'],
                
                // Incomes
                ['name' => 'Gaji', 'type' => 'income', 'icon' => '💰', 'color' => '#10B981'],
                ['name' => 'Bonus', 'type' => 'income', 'icon' => '🎉', 'color' => '#F59E0B'],
                ['name' => 'Investasi', 'type' => 'income', 'icon' => '📈', 'color' => '#3B82F6'],
                ['name' => 'Lainnya', 'type' => 'income', 'icon' => '💵', 'color' => '#84CC16'],
            ];

            foreach ($categories as $cat) {
                Category::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $cat['name'],
                    'type' => $cat['type']
                ], [
                    'icon' => $cat['icon'],
                    'color' => $cat['color']
                ]);
            }
        }
    }
}

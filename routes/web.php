<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Api\SavingApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// AUTH (PRODUCTION-SAFE)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->middleware('throttle:10,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->middleware('throttle:10,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ==========================================
// DEV-ONLY: Auto-Login untuk Development
// (TIDAK aktif di production)
// ==========================================
if (app()->environment('local')) {
    Route::get('/dev/auto-login', function () {
        // Cari user pertama di database
        $user = \App\Models\User::first();

        // Kalau databasenya kosong, buat akun otomatis untuk development
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Developer',
                'email' => 'dev@rupia.local',
                'password' => bcrypt('password123'),
            ]);
        }

        Auth::login($user);

        return redirect('/');
    })->name('dev.auto-login');
}


// ==========================================
// Rute Utama Aplikasi Rupia (Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/', [DashboardController::class, 'index']);

    // 2. Top Up Saldo
    Route::get('/topup', [TopUpController::class, 'index']);
    Route::post('/topup/process', [TopUpController::class, 'store']);

    // 3. Tabungan (Saving)
    Route::get('/saving', [SavingController::class, 'index']);
    // Backward-compatible: beberapa view submit ke POST /saving
    Route::post('/saving', [SavingController::class, 'store']);
    Route::post('/saving/store', [SavingController::class, 'store']);

    // 4. Life Event Planner
    Route::get('/planner', [PlannerController::class, 'index']);
    Route::post('/planner/store', [PlannerController::class, 'store']);

    // 5. Catat Transaksi (Pengeluaran)
    Route::get('/transaction/create', [TransactionController::class, 'create']);
    Route::post('/transaction/store', [TransactionController::class, 'store']);

    // 6. Edukasi
    Route::get('/education', function () {
        return view('education.index');
    });

    Route::post('/saving/deposit/{id}', [SavingController::class, 'addDeposit']);

    // Bayar Tagihan (Simulasi Sandbox)
    Route::get('/pay', [App\Http\Controllers\PaymentController::class, 'index']);
    Route::post('/pay/process', [App\Http\Controllers\PaymentController::class, 'process']);

    // Fitur Transfer
    Route::get('/transfer', [App\Http\Controllers\TransferController::class, 'index']);
    Route::post('/transfer/process', [App\Http\Controllers\TransferController::class, 'process']);

    // 7. Chat AI Widget (Baru ditambahkan)
    Route::post('/send-chat', [App\Http\Controllers\ChatController::class, 'send']);

    // Endpoint khusus untuk dicek guru
    Route::apiResource('api/saving', SavingApiController::class);

    // Kategori & Dompet
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('wallets', App\Http\Controllers\WalletController::class);
    
    // Riwayat Pencatatan
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index']);
    
    // Budgets
    Route::resource('budgets', App\Http\Controllers\BudgetController::class);
    
    // Savings (Target Keuangan) Edit & Delete & TopUp
    Route::put('/saving/{saving}', [App\Http\Controllers\SavingController::class, 'update']);
    Route::delete('/saving/{saving}', [App\Http\Controllers\SavingController::class, 'destroy']);
    Route::post('/saving/{id}/topup', [App\Http\Controllers\SavingController::class, 'topup']);
    
    // Statistik & Laporan
    Route::get('/statistik', [App\Http\Controllers\StatistikController::class, 'index']);
    
    // Calendar
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index']);
    Route::get('/api/calendar/events', [App\Http\Controllers\CalendarController::class, 'events']);
    
    // Reminders
    Route::resource('reminders', App\Http\Controllers\ReminderController::class);
    Route::post('/reminders/{reminder}/toggle', [App\Http\Controllers\ReminderController::class, 'toggle']);
    
    // Export & Backup
    Route::get('/export/csv', [App\Http\Controllers\ExportController::class, 'downloadCsv']);
    Route::get('/export/json', [App\Http\Controllers\ExportController::class, 'backupJson']);
    
    // Achievements
    Route::get('/achievements', [App\Http\Controllers\AchievementController::class, 'index']);

});

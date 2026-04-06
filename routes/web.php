<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// JALUR TIKUS: Auto-Login untuk Development
// ==========================================
Route::get('/login', function () {
    // Cari user pertama di database
    $user = User::first();
    
    // Kalau databasenya kosong (habis di migrate:fresh), buatin akun otomatis!
    if (!$user) {
        $user = User::create([
            'name' => 'Abdan',
            'email' => 'abdan@smktelkom.edu',
            'password' => bcrypt('password123'),
        ]);
    }
    
    // Langsung login-kan user tersebut
    Auth::login($user);
    
    // Arahkan kembali ke halaman Dashboard utama
    return redirect('/');
})->name('login');

// Rute Logout (Biar tombol keluar di Navbar berfungsi)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


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

});
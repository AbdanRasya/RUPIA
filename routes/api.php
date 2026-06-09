<?php
use App\Http\Controllers\Api\KategoriController;
// Ini endpoint API lu: http://127.0.0.1:8000/api/kategori
Route::get('/kategori', [KategoriController::class, 'index']);
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transaksi', [TransactionController::class, 'store']);
Route::get('/transaksi/{id}', [TransactionController::class, 'show']);
Route::delete('/transaksi/{id}', [TransactionController::class, 'destroy']);


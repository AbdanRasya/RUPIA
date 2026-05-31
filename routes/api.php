<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transaksi', [TransactionController::class, 'store']);
Route::get('/transaksi/{id}', [TransactionController::class, 'show']);
Route::delete('/transaksi/{id}', [TransactionController::class, 'destroy']);
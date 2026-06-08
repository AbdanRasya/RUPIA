<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Daftar kolom yang BOLEH diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'wallet_id',
        'reference_wallet_id',
        'type',
        'category',
        'amount',
        'mood',
        'payment_method',
        'status',
        'description',
        'attachment',
        'transaction_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function referenceWallet()
    {
        return $this->belongsTo(Wallet::class, 'reference_wallet_id');
    }
}
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
        'type',
        'category',
        'amount',
        'mood',
        'payment_method',
        'status',
        'description'
    ];
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $group) {
            $group->id();
            $group->foreignId('user_id')->constrained()->onDelete('cascade');
            $group->enum('type', ['income', 'expense']); // income = Top Up, expense = Jajan
            $group->string('category')->nullable(); // Food, Transport, Topup
            $group->bigInteger('amount');
            $group->string('mood')->nullable(); // Happy, Stress, dll
            $group->string('payment_method')->default('manual'); // QRIS, VA, Cash
            $group->enum('status', ['pending', 'success', 'failed'])->default('success'); 
            $group->text('description')->nullable();
            $group->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
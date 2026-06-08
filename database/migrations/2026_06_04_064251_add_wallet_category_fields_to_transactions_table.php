<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('wallet_id')->nullable()->constrained('wallets')->onDelete('set null');
            $table->string('attachment')->nullable();
            $table->date('transaction_date')->nullable();
            // Optional: reference_wallet_id for transfers
            $table->foreignId('reference_wallet_id')->nullable()->constrained('wallets')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropForeign(['reference_wallet_id']);
            $table->dropColumn(['wallet_id', 'attachment', 'transaction_date', 'reference_wallet_id']);
        });
    }
};

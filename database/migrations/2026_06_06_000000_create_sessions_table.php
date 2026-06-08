<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: project ini sudah membuat tabel sessions di migration awal.
        // Migration tambahan ini dibuat agar konsisten jika tabel sessions belum ada
        // (mis. saat sebagian migration dipakai), tapi tidak boleh memicu error jika sudah ada.
        if (Schema::hasTable('sessions')) {
            return;
        }

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Jangan hapus jika tabel sessions dibuat oleh migration lain.
        // Jika dibutuhkan, rollback yang aman adalah menghapus manual migration ini dari batch.
        if (! Schema::hasTable('sessions')) {
            return;
        }
    }
};

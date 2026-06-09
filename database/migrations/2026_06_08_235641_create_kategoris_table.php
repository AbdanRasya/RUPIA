<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('kategoris', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kategori'); // contoh: 'Makanan', 'Gaji'
        $table->enum('tipe', ['pemasukan', 'pengeluaran']); // cuma bisa diisi 2 kata ini
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};

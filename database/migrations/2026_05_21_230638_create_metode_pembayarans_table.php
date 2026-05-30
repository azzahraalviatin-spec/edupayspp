<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metode_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50); // contoh: BCA, BRI, DANA, GoPay
            $table->enum('jenis', ['bank', 'ewallet', 'tunai']); // jenis metode
            $table->string('no_rekening', 50)->nullable(); // nomor rekening / no hp
            $table->string('atas_nama', 100)->nullable(); // nama pemilik rekening
            $table->string('logo', 100)->nullable(); // logo bank/ewallet (opsional)
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metode_pembayarans');
    }
};
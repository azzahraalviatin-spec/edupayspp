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
    Schema::table('pembayarans', function (Blueprint $table) {

        if (!Schema::hasColumn('pembayarans', 'metode_pembayaran')) {
            $table->string('metode_pembayaran')->nullable();
        }

        if (!Schema::hasColumn('pembayarans', 'uang_dibayar')) {
            $table->bigInteger('uang_dibayar')->nullable();
        }

        if (!Schema::hasColumn('pembayarans', 'kembalian')) {
            $table->bigInteger('kembalian')->nullable();
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            //
        });
    }
};

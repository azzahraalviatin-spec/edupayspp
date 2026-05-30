<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_potongan', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);

            // Tambah kolom baru berbasis bulan + tahun
            $table->tinyInteger('bulan_mulai')->after('potongan_spp_id')->comment('1-12');
            $table->smallInteger('tahun_mulai')->after('bulan_mulai');
            $table->tinyInteger('bulan_selesai')->after('tahun_mulai')->comment('1-12');
            $table->smallInteger('tahun_selesai')->after('bulan_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('siswa_potongan', function (Blueprint $table) {
            $table->dropColumn(['bulan_mulai', 'tahun_mulai', 'bulan_selesai', 'tahun_selesai']);

            $table->date('tanggal_mulai')->after('potongan_spp_id');
            $table->date('tanggal_selesai')->after('tanggal_mulai');
        });
    }
};
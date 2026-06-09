<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class AutoAktifTahunAjaran extends Command
{
    protected $signature = 'tahun-ajaran:auto-aktif';
    protected $description = 'Otomatis aktifkan tahun ajaran berdasarkan tanggal sekarang';

    public function handle()
    {
        $sekarang = Carbon::now();

        // Cari tahun ajaran yang tanggal_mulai <= sekarang <= tanggal_selesai
        $tahunAktif = TahunAjaran::where('tanggal_mulai', '<=', $sekarang)
            ->where('tanggal_selesai', '>=', $sekarang)
            ->first();

        if ($tahunAktif) {
            // Nonaktifkan semua dulu
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => 0]);

            // Aktifkan yang sesuai
            $tahunAktif->update(['is_aktif' => 1]);

            $this->info('Tahun ajaran ' . $tahunAktif->nama . ' berhasil diaktifkan otomatis!');
        } else {
            $this->warn('Tidak ada tahun ajaran yang sesuai dengan tanggal sekarang.');
        }
    }
}
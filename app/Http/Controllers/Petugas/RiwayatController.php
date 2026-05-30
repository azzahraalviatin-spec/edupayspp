<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Pembayaran::with(['tagihan.siswa.kelas', 'tagihan.tahunAjaran', 'petugas'])
            ->where('status_verifikasi', 'valid')
            ->latest()
            ->paginate(15);

        $totalBulanIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

        $totalHariIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereDate('tanggal_bayar', Carbon::today())
            ->sum('jumlah_bayar');

        return view('petugas.riwayat.index', compact('riwayat', 'totalBulanIni', 'totalHariIni'));
    }
}
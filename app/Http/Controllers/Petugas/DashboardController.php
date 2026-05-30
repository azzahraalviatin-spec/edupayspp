<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMenunggu   = Pembayaran::where('status_verifikasi', 'pending')->count();
        $totalLunas      = Tagihan::where('status', 'lunas')->count();
        $totalBelumBayar = Tagihan::where('status', 'belum_bayar')->count();

        $pemasukanHariIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereDate('tanggal_bayar', Carbon::today())
            ->sum('jumlah_bayar');

        $pemasukanBulanIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

        $menungguVerifikasi = Pembayaran::with(['tagihan.siswa.kelas'])
            ->where('status_verifikasi', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $siswaNunggak = Tagihan::with(['siswa.kelas'])
            ->where('status', 'belum_bayar')
            ->where('bulan', Carbon::now()->month)
            ->latest()
            ->take(8)
            ->get();

        return view('petugas.dashboard', compact(
            'totalMenunggu',
            'totalLunas',
            'totalBelumBayar',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'menungguVerifikasi',
            'siswaNunggak'
        ));
    }
}
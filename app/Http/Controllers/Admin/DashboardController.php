<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa      = Siswa::where('status', 'aktif')->count();
        $totalLunas      = Tagihan::where('status', 'lunas')->count();
        $totalBelumBayar = Tagihan::where('status', 'belum_bayar')->count();
        $totalMenunggu   = Tagihan::where('status', 'menunggu')->count();

        $pemasukanHariIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereDate('tanggal_bayar', Carbon::today())
            ->sum('jumlah_bayar');

        $pemasukanBulanIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

  // PERBAIKAN SAKTI: Hanya mengambil 4 data siswa nunggak paling terbaru dari database MySQL
        $siswaNunggak = Tagihan::with('siswa.kelas') // Sesuaikan dengan nama nama relasi model kamu
                            ->where('status', 'Belum Bayar') // Memastikan hanya yang nunggak
                            ->latest()                       // Mengurutkan dari yang paling baru input
                            ->take(4)                        // Kunci paten cuma ambil 4 data saja
                            ->get();
        $menungguVerifikasi = Pembayaran::with(['tagihan.siswa.kelas'])
            ->where('status_verifikasi', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $grafikBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikBulanan[] = Pembayaran::where('status_verifikasi', 'valid')
                ->whereMonth('tanggal_bayar', $i)
                ->whereYear('tanggal_bayar', Carbon::now()->year)
                ->sum('jumlah_bayar');
        }

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalLunas',
            'totalBelumBayar',
            'totalMenunggu',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'siswaNunggak',
            'menungguVerifikasi',
            'grafikBulanan'
        ));
    }
}
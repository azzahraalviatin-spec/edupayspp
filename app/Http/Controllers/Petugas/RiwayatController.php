<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['tagihan.siswa.kelas', 'tagihan.tahunAjaran', 'petugas'])
            ->where('status_verifikasi', 'valid');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        $riwayat = $query->latest()->paginate(15)->withQueryString();

        // Hitung total sesuai filter
        $queryTotal = Pembayaran::where('status_verifikasi', 'valid');
        if ($request->filled('dari'))   $queryTotal->whereDate('tanggal_bayar', '>=', $request->dari);
        if ($request->filled('sampai')) $queryTotal->whereDate('tanggal_bayar', '<=', $request->sampai);
        if ($request->filled('bulan'))  $queryTotal->whereMonth('tanggal_bayar', $request->bulan);
        if ($request->filled('tahun'))  $queryTotal->whereYear('tanggal_bayar', $request->tahun);
        $totalFilter = $queryTotal->sum('jumlah_bayar');

        $totalBulanIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

        $totalHariIni = Pembayaran::where('status_verifikasi', 'valid')
            ->whereDate('tanggal_bayar', Carbon::today())
            ->sum('jumlah_bayar');

        $adaFilter = $request->hasAny(['dari', 'sampai', 'bulan', 'tahun']);

        return view('petugas.riwayat.index', compact(
            'riwayat', 'totalBulanIni', 'totalHariIni', 'totalFilter', 'adaFilter'
        ));
    }
}
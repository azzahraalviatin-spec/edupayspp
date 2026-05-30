<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan!');
        }

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $sekarang = ($tahunIni * 12) + $bulanIni; // ← tambahan ini

        $totalTagihan    = Tagihan::where('siswa_id', $siswa->id)->count();
        $totalLunas      = Tagihan::where('siswa_id', $siswa->id)->where('status', 'lunas')->count();
        $totalBelumBayar = Tagihan::where('siswa_id', $siswa->id)->where('status', 'belum_bayar')->count();
        $totalMenunggu   = Tagihan::where('siswa_id', $siswa->id)->where('status', 'menunggu')->count();

        $tagihanBulanIni = Tagihan::with(['tahunAjaran', 'pembayaran'])
            ->where('siswa_id', $siswa->id)
            ->where('bulan', $bulanIni)
            ->first();

        $potonganAktif = $siswa->potonganSpps()
            ->wherePivot('is_aktif', true)
            ->get()
            ->filter(function ($item) use ($sekarang) {
                $mulai   = ($item->pivot->tahun_mulai * 12) + $item->pivot->bulan_mulai;
                $selesai = ($item->pivot->tahun_selesai * 12) + $item->pivot->bulan_selesai;
                return $sekarang >= $mulai && $sekarang <= $selesai;
            });

        $riwayat = Tagihan::with(['pembayaran', 'tahunAjaran'])
            ->where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->orderBy('bulan', 'desc')
            ->take(5)
            ->get();

        $bulanList = [
            1=>'Januari',  2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',      6=>'Juni',     7=>'Juli',     8=>'Agustus',
            9=>'September',10=>'Oktober', 11=>'November',12=>'Desember'
        ];

        return view('siswa.dashboard', compact(
            'siswa',
            'totalTagihan',
            'totalLunas',
            'totalBelumBayar',
            'totalMenunggu',
            'tagihanBulanIni',
            'potonganAktif',
            'riwayat',
            'bulanList'
        ));
    }
}
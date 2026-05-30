<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $riwayat = Tagihan::with(['pembayaran', 'tahunAjaran'])
            ->where('siswa_id', $siswa->id)
            ->where('status', 'lunas')
            ->orderBy('bulan', 'desc')
            ->paginate(10);

        $bulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        return view('siswa.riwayat', compact('riwayat', 'bulanList', 'siswa'));
    }
}
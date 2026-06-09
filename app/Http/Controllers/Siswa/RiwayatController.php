<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;

        $query = Tagihan::with(['pembayaran', 'tahunAjaran'])
            ->where('siswa_id', $siswa->id)
            ->where('status', 'lunas');

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        $riwayat = $query->orderBy('bulan', 'desc')->paginate(10)->withQueryString();

        // Total sesuai filter
        $queryTotal = Tagihan::where('siswa_id', $siswa->id)->where('status', 'lunas');
        if ($request->filled('bulan')) $queryTotal->where('bulan', $request->bulan);
        if ($request->filled('tahun_ajaran')) $queryTotal->where('tahun_ajaran_id', $request->tahun_ajaran);
        $totalFilter = $queryTotal->with('pembayaran')->get()->sum(fn($t) => $t->pembayaran->jumlah_bayar ?? 0);

        $adaFilter = $request->hasAny(['bulan', 'tahun_ajaran']);

        $bulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        $tahunAjaranList = \App\Models\TahunAjaran::orderBy('nama', 'desc')->get();

        return view('siswa.riwayat', compact('riwayat', 'bulanList', 'siswa', 'tahunAjaranList', 'totalFilter', 'adaFilter'));
    }
}
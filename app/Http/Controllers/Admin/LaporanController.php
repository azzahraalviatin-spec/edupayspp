<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class LaporanController extends Controller
{
    private function getNamaBulan()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }

    public function index(Request $request)
    {
        $query = Pembayaran::with([
            'tagihan.siswa.kelas',
            'petugas'
        ])->orderBy('created_at', 'desc');

        // 1. Filter Berdasarkan Bulan
        if ($request->filled('bulan')) {
            $bulan_pilihan = $request->bulan;
            $query->where(function($q) use ($bulan_pilihan) {
                $q->where('bulan_dibayar', $bulan_pilihan)
                  ->orWhere('bulan', $bulan_pilihan)
                  ->orWhereHas('tagihan', function($sq) use ($bulan_pilihan) {
                      $sq->where('bulan', $bulan_pilihan)
                        ->orWhere('bulan_dibayar', $bulan_pilihan);
                  });
            });
        }

        // 2. FIX FILTER TAHUN: Cari murni berdasarkan tahun tanggal pembayaran asli di tabel pembayarans
        if ($request->filled('tahun')) {
            $tahun_pilihan = $request->tahun;
            $query->where(function($q) use ($tahun_pilihan) {
                $q->whereYear('tanggal_bayar', $tahun_pilihan)
                  ->orWhereYear('created_at', $tahun_pilihan);
            });
        }

        // 3. Filter Berdasarkan Pencarian Nama/NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tagihan.siswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Pagination tetap 10 data
        $laporans = $query->paginate(10)->withQueryString();

        // Konversi angka bulan jadi teks Indonesia
        $nama_bulan = $this->getNamaBulan();
        foreach ($laporans as $lap) {
            $bulan_angka = $lap->bulan_dibayar ?? $lap->bulan ?? $lap->tagihan->bulan ?? $lap->tagihan->bulan_dibayar ?? null;
            if (is_numeric($bulan_angka) && isset($nama_bulan[(int)$bulan_angka])) {
                $lap->bulan_teks = $nama_bulan[(int)$bulan_angka];
            } else {
                $lap->bulan_teks = $bulan_angka ?? '-';
            }
        }

        // List tahun dari 2001 - 2040
        $list_tahun = range(2001, 2040);

        return view('admin.laporan.index', compact('laporans', 'nama_bulan', 'list_tahun'));
    }

  public function downloadPdf(Request $request)
    {
        // 1. Ambil data pembayaran beserta relasi siswa, kelas, dan petugasnya
        $query = Pembayaran::with([
            'tagihan.siswa.kelas',
            'petugas'
        ]);

        // 2. Jalankan Filter Bulan jika admin memilih bulan
        if ($request->filled('bulan')) {
            $bulan_pilihan = $request->bulan;
            $query->where(function($q) use ($bulan_pilihan) {
                $q->where('bulan_dibayar', $bulan_pilihan)
                  ->orWhere('bulan', $bulan_pilihan)
                  ->orWhereHas('tagihan', function($sq) use ($bulan_pilihan) {
                      $sq->where('bulan', $bulan_pilihan)
                        ->orWhere('bulan_dibayar', $bulan_pilihan);
                  });
            });
        }

        // 3. Jalankan Filter Tahun jika admin memilih tahun
        if ($request->filled('tahun')) {
            $tahun_pilihan = $request->tahun;
            $query->where(function($q) use ($tahun_pilihan) {
                $q->whereYear('tanggal_bayar', $tahun_pilihan)
                  ->orWhereYear('created_at', $tahun_pilihan);
            });
        }

        // 4. Jalankan Filter Pencarian Nama/NIS jika ada teks yang dicari
        if ($request->filled('search')) {
            $query->whereHas('tagihan.siswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // 5. Eksekusi query ke database
        $laporans = $query->orderBy('created_at', 'desc')->get();
        
        // 6. Pemetaan angka bulan ke teks Indonesia (Biar nama siswa, kelas, & bulan muncul di PDF)
        $nama_bulan = $this->getNamaBulan();
        
        foreach ($laporans as $lap) {
            $bulan_angka = $lap->bulan_dibayar ?? $lap->bulan ?? $lap->tagihan->bulan ?? $lap->tagihan->bulan_dibayar ?? null;
            if (is_numeric($bulan_angka) && isset($nama_bulan[(int)$bulan_angka])) {
                $lap->bulan_teks = $nama_bulan[(int)$bulan_angka];
            } else {
                $lap->bulan_teks = $bulan_angka ?? '-';
            }
        }

        // 7. Lempar data ke template cetak-pdf dan download filenya
        $pdf = Pdf::loadView('admin.laporan.cetak-pdf', compact('laporans'));
        return $pdf->download('Laporan_Pembayaran_SPP_' . date('Ymd') . '.pdf');
    }
}
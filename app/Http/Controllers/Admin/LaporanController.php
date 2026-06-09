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

    // Fungsi reusable untuk apply filter ke query
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('bulan')) {
            $query->whereHas('tagihan', fn($q) => $q->where('bulan', $request->bulan));
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tagihan.siswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        $nama_bulan = $this->getNamaBulan();

        // === QUERY DATA TABEL (pagination) ===
        $query = Pembayaran::with(['tagihan.siswa.kelas', 'petugas'])
                    ->orderBy('created_at', 'desc');
        $query = $this->applyFilters($query, $request);
        $laporans = $query->paginate(10)->withQueryString();

        // Konversi angka bulan jadi teks Indonesia
        foreach ($laporans as $lap) {
            $bulan_angka = $lap->tagihan->bulan ?? null;
            if (is_numeric($bulan_angka) && isset($nama_bulan[(int)$bulan_angka])) {
                $lap->bulan_teks = $nama_bulan[(int)$bulan_angka];
            } else {
                $lap->bulan_teks = '-';
            }
        }

        // === QUERY SUMMARY CARDS (tanpa pagination, pakai filter yang sama) ===
        $summaryQuery = Pembayaran::query();
        $summaryQuery = $this->applyFilters($summaryQuery, $request);
        $allData = $summaryQuery->get();

        // Hitung summary berdasarkan status_verifikasi
        $totalPendapatan = $allData->where('status_verifikasi', 'valid')->sum('jumlah_bayar');
        $totalTransaksi  = $allData->where('status_verifikasi', 'valid')->count();
        $totalPending    = $allData->where('status_verifikasi', 'pending')->count();
        $rataRata        = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Label filter untuk ditampilkan di card
        $filterLabel = 'Semua Data';
        if ($request->filled('search')) {
            $filterLabel = 'Pencarian: ' . $request->search;
        }
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $filterLabel = $nama_bulan[$request->bulan] . ' ' . $request->tahun;
        } elseif ($request->filled('bulan')) {
            $filterLabel = $nama_bulan[$request->bulan];
        } elseif ($request->filled('tahun')) {
            $filterLabel = 'Tahun ' . $request->tahun;
        }

        $list_tahun = range(2001, 2040);

        return view('admin.laporan.index', compact(
            'laporans', 'nama_bulan', 'list_tahun',
            'totalPendapatan', 'totalTransaksi', 'totalPending',
            'rataRata', 'filterLabel'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $query = Pembayaran::with(['tagihan.siswa.kelas', 'petugas']);
        $query = $this->applyFilters($query, $request);
        $laporans = $query->orderBy('created_at', 'desc')->get();

        $nama_bulan = $this->getNamaBulan();
        foreach ($laporans as $lap) {
            $bulan_angka = $lap->tagihan->bulan ?? null;
            if (is_numeric($bulan_angka) && isset($nama_bulan[(int)$bulan_angka])) {
                $lap->bulan_teks = $nama_bulan[(int)$bulan_angka];
            } else {
                $lap->bulan_teks = '-';
            }
        }

        $pdf = Pdf::loadView('admin.laporan.cetak-pdf', compact('laporans'));
        return $pdf->download('Laporan_Pembayaran_SPP_' . date('Ymd') . '.pdf');
    }
}
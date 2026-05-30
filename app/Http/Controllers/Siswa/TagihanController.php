<?php

namespace App\Http\Controllers\Siswa;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TagihanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $tagihans = Tagihan::with(['tahunAjaran', 'pembayaran', 'siswa.potonganSpps'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('bulan', 'desc')
            ->get();

        $bulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        return view('siswa.tagihan', compact('tagihans', 'bulanList', 'siswa'));
    }

    public function prosesBayar($id)
    {
        $tagihan = Tagihan::with(['tahunAjaran', 'siswa.potonganSpps'])->findOrFail($id);

        // ===== HITUNG POTONGAN OTOMATIS =====
        $bulanTagihan = $tagihan->bulan;
        $tahunTagihan = $tagihan->tahunAjaran->tahun_mulai ?? now()->year;
        $sekarang     = ($tahunTagihan * 12) + $bulanTagihan;

        $potonganAktif = $tagihan->siswa->potonganSpps->filter(function($p) use ($sekarang) {
            $mulai   = ($p->pivot->tahun_mulai * 12) + $p->pivot->bulan_mulai;
            $selesai = ($p->pivot->tahun_selesai * 12) + $p->pivot->bulan_selesai;
            return $p->pivot->is_aktif && $sekarang >= $mulai && $sekarang <= $selesai;
        });

        $totalPotongan = $potonganAktif->sum('nominal_potongan');
        $nominalBayar  = max(0, $tagihan->nominal_awal - $totalPotongan);

        // Update tagihan kalau potongan berubah
        if ($tagihan->total_potongan != $totalPotongan || $tagihan->nominal_bayar != $nominalBayar) {
            $tagihan->update([
                'total_potongan' => $totalPotongan,
                'nominal_bayar'  => $nominalBayar,
            ]);
            $tagihan->refresh();
        }

        $bulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

        // ===== AMBIL METODE PEMBAYARAN DARI DB (yang aktif, bukan tunai) =====
        $metodePembayarans = MetodePembayaran::where('is_aktif', true)
            
            ->orderBy('jenis')
            ->orderBy('nama')
            ->get();

        return view('siswa.bayar_Ringkasan', compact(
            'tagihan',
            'bulanList',
            'pembayaran',
            'potonganAktif',
            'totalPotongan',
            'metodePembayarans'
        ));
    }

    public function simpanMetode(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $request->validate([
            'metode_bayar' => 'required|exists:metode_pembayarans,id',
        ]);

        $metode = MetodePembayaran::findOrFail($request->metode_bayar);

        Pembayaran::updateOrCreate(
            ['tagihan_id' => $tagihan->id],
            [
                'tanggal_bayar'     => Carbon::now(),
                'jumlah_bayar'      => $tagihan->nominal_bayar,
                'metode_bayar' => $metode->jenis,
                'status_verifikasi' => 'pending',
            ]
        );

        return redirect()->back()->with('success', 'Metode pembayaran berhasil dipilih! Silakan transfer dan upload bukti.');
    }

    public function upload(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diupload!',
            'bukti_transfer.image'    => 'File harus berupa gambar!',
            'bukti_transfer.max'      => 'Ukuran file maksimal 2MB!',
        ]);

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

        if ($pembayaran) {
            $pembayaran->update([
                'bukti_transfer' => $path,
                'tanggal_bayar'  => Carbon::now(),
                'jumlah_bayar'   => $tagihan->nominal_bayar,
            ]);
        } else {
            Pembayaran::create([
                'tagihan_id'        => $tagihan->id,
                'tanggal_bayar'     => Carbon::now(),
                'jumlah_bayar'      => $tagihan->nominal_bayar,
                'metode_bayar'      => 'transfer',
                'bukti_transfer'    => $path,
                'status_verifikasi' => 'pending',
            ]);
        }

        $tagihan->update(['status' => 'menunggu']);

        return redirect()->route('siswa.tagihan')->with('success', 'Bukti transfer berhasil diupload! Menunggu verifikasi.');
    }

    public function kwitansi(Tagihan $tagihan)
    {
        $tagihan->load(['siswa.kelas', 'tahunAjaran', 'pembayaran']);

        $bulanList = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        return view('siswa.kwitansi', compact('tagihan', 'bulanList'));
    }

    public function downloadPdf(Tagihan $tagihan)
    {
        $tagihan->load(['siswa.kelas', 'tahunAjaran', 'pembayaran']);

        $bulanList = [
            1=>'Januari',  2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',      6=>'Juni',     7=>'Juli',     8=>'Agustus',
            9=>'September',10=>'Oktober', 11=>'November',12=>'Desember'
        ];

        $pdf = Pdf::loadView('siswa.kwitansi-pdf', compact('tagihan', 'bulanList'))
                   ->setPaper('a4', 'portrait');

        $namaFile = 'kwitansi-' . ($tagihan->pembayaran->no_kwitansi ?? $tagihan->id) . '.pdf';

        return $pdf->download($namaFile);
    }
    public function resetMetode($id)
{
    $tagihan = Tagihan::findOrFail($id);

    Pembayaran::where('tagihan_id', $tagihan->id)
        ->update(['metode_bayar' => null]);

    return redirect()->route('siswa.tagihan.bayar', $id);
}
}
<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        $pending = Pembayaran::with(['tagihan.siswa.kelas'])
            ->where('status_verifikasi', 'pending')
            ->latest()
            ->get();

        return view('petugas.verifikasi.index', compact('pending'));
    }

    public function konfirmasi(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status_verifikasi' => 'valid',
            'petugas_id'        => Auth::id(),
            'no_kwitansi'       => $this->generateNoKwitansi(),
        ]);

        $pembayaran->tagihan->update(['status' => 'lunas']);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function tolak(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500',
        ]);

        $pembayaran->update([
            'status_verifikasi' => 'tolak',
            'alasan_tolak'      => $request->alasan_tolak,
        ]);

        $pembayaran->tagihan->update(['status' => 'belum_bayar']);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function konfirmasiSemua()
    {
        $pending = Pembayaran::with('tagihan')
            ->where('status_verifikasi', 'pending')
            ->get();

        foreach ($pending as $bayar) {
            $bayar->update([
                'status_verifikasi' => 'valid',
                'petugas_id'        => Auth::id(),
                'no_kwitansi'       => $this->generateNoKwitansi(),
            ]);
            $bayar->tagihan->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Semua pembayaran berhasil dikonfirmasi!');
    }

    private function generateNoKwitansi(): string
    {
        return 'KW-' . strtoupper(uniqid());
    }
}
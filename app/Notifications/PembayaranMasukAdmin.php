<?php

namespace App\Notifications;

use App\Models\Pembayaran;
use Illuminate\Notifications\Notification;

class PembayaranMasukAdmin extends Notification
{
    protected $pembayaran;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $bulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        $namaSiswa = $this->pembayaran->tagihan->siswa->nama ?? '-';
        $namaBulan = $bulan[$this->pembayaran->tagihan->bulan] ?? '-';
        $nominal   = number_format($this->pembayaran->jumlah_bayar, 0, ',', '.');
        $metode    = $this->pembayaran->metode_pembayaran === 'tunai' ? 'Tunai (Bendahara)' : 'Transfer';

        return [
            'type'        => 'pembayaran_masuk',
            'judul'       => 'Pembayaran SPP Masuk 💰',
            'pesan'       => "{$namaSiswa} membayar SPP {$namaBulan} sebesar Rp {$nominal} via {$metode}",
            'url'         => '/admin/dashboard',
            'icon'        => 'bi-cash-coin',
            'warna'       => 'success',
            'no_kwitansi' => $this->pembayaran->no_kwitansi,
        ];
    }
}
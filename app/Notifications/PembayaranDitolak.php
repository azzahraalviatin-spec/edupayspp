<?php

namespace App\Notifications;

use App\Models\Pembayaran;
use Illuminate\Notifications\Notification;

class PembayaranDitolak extends Notification
{
    protected $pembayaran;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $bulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];

        return [
            'type'  => 'pembayaran_ditolak',
            'judul' => 'Pembayaran Ditolak ❌',
            'pesan' => 'Pembayaran SPP bulan ' . $bulan[$this->pembayaran->tagihan->bulan] . ' ditolak. Alasan: ' . $this->pembayaran->alasan_tolak,
            'url'   => '/siswa/tagihan',
            'icon'  => 'bi-x-circle-fill',
            'warna' => 'danger',
        ];
    }
}
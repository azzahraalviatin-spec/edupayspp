<?php

namespace App\Notifications;

use App\Models\Tagihan;
use Illuminate\Notifications\Notification;

class TagihanBaru extends Notification
{
    protected $tagihan;

    public function __construct(Tagihan $tagihan)
    {
        $this->tagihan = $tagihan;
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
            'type'    => 'tagihan_baru',
            'judul'   => 'Tagihan SPP Baru',
            'pesan'   => 'Tagihan SPP bulan ' . $bulan[$this->tagihan->bulan] . ' sebesar Rp ' . number_format($this->tagihan->nominal_bayar, 0, ',', '.') . ' telah diterbitkan.',
            'url'     => '/siswa/tagihan',
            'icon'    => 'bi-file-earmark-text-fill',
            'warna'   => 'warning',
        ];
    }
}
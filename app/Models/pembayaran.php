<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'tagihan_id',
        'jumlah_bayar',
        'uang_dibayar',
        'uang_diterima',
        'kembalian',
        'metode_bayar',
        'metode_pembayaran',
        'status_verifikasi',
        'tanggal_bayar',
        'petugas_id',
        'no_kwitansi',
        'bukti_transfer',
        'alasan_tolak',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
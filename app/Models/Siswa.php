<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nis',
        'nama',
        'jenis_kelamin',
        'no_hp_ortu',
        'nama_ortu',
        'tahun_masuk',
        'status',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke tagihan
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Relasi ke potongan SPP — pivot pakai bulan+tahun
    public function potonganSpps()
    {
        return $this->belongsToMany(PotonganSpp::class, 'siswa_potongan', 'siswa_id', 'potongan_spp_id')
                    ->withPivot('bulan_mulai', 'tahun_mulai', 'bulan_selesai', 'tahun_selesai', 'is_aktif', 'keterangan')
                    ->withTimestamps();
    }
}
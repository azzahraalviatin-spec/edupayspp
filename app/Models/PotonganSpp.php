<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotonganSpp extends Model
{
    use HasFactory;

    protected $table = 'potongan_spps';

    protected $fillable = [
        'nama',
        'jenis',
        'nominal_potongan',
    ];

    // Relasi ke siswa (many-to-many via siswa_potongan)
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_potongan', 'potongan_spp_id', 'siswa_id')
                    ->withPivot('bulan_mulai', 'tahun_mulai', 'bulan_selesai', 'tahun_selesai', 'is_aktif', 'keterangan')
                    ->withTimestamps();
    }
}
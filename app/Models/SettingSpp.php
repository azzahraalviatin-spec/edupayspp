<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSpp extends Model
{
    protected $table = 'settings_spp';

    protected $fillable = [
        'kelas_id',
        'tahun_ajaran_id',
        'nominal',
    ];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
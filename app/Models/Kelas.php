<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'jurusan',
        'nomor_kelas',
        'wali_kelas',
    ];

    // Relasi ke siswa
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke settings SPP
    public function settingSpps()
    {
        return $this->hasMany(SettingSpp::class);
    }
}
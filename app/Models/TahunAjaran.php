<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif' => 'boolean',
    ];

    // Relasi ke tagihan
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Relasi ke settings SPP
    public function settingSpps()
    {
        return $this->hasMany(SettingSpp::class);
    }
}
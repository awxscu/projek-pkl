<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    protected $table = 'pelabuhan';
    protected $primaryKey = 'id_pelabuhan';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelabuhan',
    ];

    public function perjalananAsal()
    {
        return $this->hasMany(JadwalPerjalanan::class, 'id_pelabuhan_asal', 'id_pelabuhan');
    }

    public function perjalananTujuan()
    {
        return $this->hasMany(JadwalPerjalanan::class, 'id_pelabuhan_tujuan', 'id_pelabuhan');
    }
}

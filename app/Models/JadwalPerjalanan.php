<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPerjalanan extends Model
{
    protected $table = 'jadwal_perjalanan';
    protected $primaryKey = 'id_perjalanan';

    protected $fillable = [
        'kode_vessel',
        'id_status',
        'id_pelabuhan_asal',
        'id_pelabuhan_tujuan',
        'jadwal_berangkat',
        'jadwal_tiba',
    ];

    protected $casts = [
        'jadwal_berangkat' => 'datetime',
        'jadwal_tiba' => 'datetime',
    ];

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kode_vessel', 'kode_vessel');
    }

    public function statusPerjalanan()
    {
        return $this->belongsTo(StatusPerjalanan::class, 'id_status', 'id_status');
    }

    public function pelabuhanAsal()
    {
        return $this->belongsTo(Pelabuhan::class, 'id_pelabuhan_asal', 'id_pelabuhan');
    }

    public function pelabuhanTujuan()
    {
        return $this->belongsTo(Pelabuhan::class, 'id_pelabuhan_tujuan', 'id_pelabuhan');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'id_perjalanan', 'id_perjalanan');
    }
}

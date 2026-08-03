<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kapal extends Model
{
    protected $table = 'kapal';
    protected $primaryKey = 'kode_vessel';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode_vessel',
        'nama_kapal',
        'id_perusahaan',
        'id_ftit',
    ];

    protected $appends = ['stok_bbm', 'status'];

    public function getStokBbmAttribute()
    {
        $latestLog = $this->logbooks()->orderBy('tanggal_pencatatan', 'desc')->first();
        if ($latestLog) {
            $fo = $latestLog->detailPemakaians()->first();
            if ($fo) {
                return $fo->sisa_sekarang;
            }
        }
        return 125000; // Default baseline stock
    }

    public function getStatusAttribute()
    {
        return 'Aktif';
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function ftit()
    {
        return $this->belongsTo(Ftit::class, 'id_ftit', 'id_ftit');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'kode_vessel', 'kode_vessel');
    }
}

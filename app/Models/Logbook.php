<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';
    protected $primaryKey = 'id_logbook';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'kode_vessel',
        'id_status',
        'tanggal_pencatatan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pencatatan' => 'date',
    ];

    protected $appends = ['tanggal_pencataan'];

    // Accessor and Mutator for old property name (tanggal_pencataan) compatibility
    public function getTanggalPencataanAttribute()
    {
        return $this->tanggal_pencatatan;
    }

    public function setTanggalPencataanAttribute($value)
    {
        $this->attributes['tanggal_pencatatan'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function statusPengisian()
    {
        return $this->belongsTo(StatusPengisian::class, 'id_status', 'id_status');
    }

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kode_vessel', 'kode_vessel');
    }

    public function detailPemakaians()
    {
        return $this->hasMany(DetailPemakaian::class, 'id_logbook', 'id_logbook');
    }
}

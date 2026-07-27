<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemakaian extends Model
{
    protected $table = 'detail_pemakaian';
    protected $primaryKey = 'id_detail';

    public $timestamps = true;

    protected $fillable = [
        'id_logbook',
        'id_ftit',
        'sisa_kemarin',
        'mesin_induk',
        'mesin_bantu',
        'lain_lain',
        'total',
        'sisa_sekarang',
        'ditambah',
        'jumlah',
        'sisakemarin_seharusnya',
        'total_seharusnya',
        'sisasekarang_seharusnya',
        'ditambah_seharusnya',
        'jumlah_seharusnya',
    ];

    protected $appends = ['motor_induk', 'motor_bantu', 'jumlah_sekarang', 'id_jenis'];

    // Accessors for old attributes compatibility
    public function getMotorIndukAttribute()
    {
        return $this->attributes['mesin_induk'] ?? 0;
    }

    public function setMotorIndukAttribute($value)
    {
        $this->attributes['mesin_induk'] = $value;
    }

    public function getMotorBantuAttribute()
    {
        return $this->attributes['mesin_bantu'] ?? 0;
    }

    public function setMotorBantuAttribute($value)
    {
        $this->attributes['mesin_bantu'] = $value;
    }

    public function getJumlahSekarangAttribute()
    {
        return $this->attributes['jumlah'] ?? 0;
    }

    public function setJumlahSekarangAttribute($value)
    {
        $this->attributes['jumlah'] = $value;
    }

    public function getIdJenisAttribute()
    {
        return 2; // Always return 2 (represents Fuel Oil in the system)
    }

    public function logbook()
    {
        return $this->belongsTo(Logbook::class, 'id_logbook', 'id_logbook');
    }

    public function ftit()
    {
        return $this->belongsTo(Ftit::class, 'id_ftit', 'id_ftit');
    }
}

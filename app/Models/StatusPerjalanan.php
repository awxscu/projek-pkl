<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPerjalanan extends Model
{
    protected $table = 'status_perjalanan';
    protected $primaryKey = 'id_status';
    public $timestamps = false;

    protected $fillable = [
        'nama_status',
    ];

    public function jadwalPerjalanans()
    {
        return $this->hasMany(JadwalPerjalanan::class, 'id_status', 'id_status');
    }
}

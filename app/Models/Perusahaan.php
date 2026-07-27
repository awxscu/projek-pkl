<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'id_perusahaan',
        'nama_perusahaan',
    ];

    public function kapals()
    {
        return $this->hasMany(Kapal::class, 'id_perusahaan', 'id_perusahaan');
    }
}

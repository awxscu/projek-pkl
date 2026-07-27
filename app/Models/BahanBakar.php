<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    protected $table = 'bahan_bakar';
    protected $primaryKey = 'id_jenis';
    public $timestamps = false;

    protected $fillable = [
        'nama_bahan_bakar',
    ];

    public function detailPemakaians()
    {
        return $this->hasMany(DetailPemakaian::class, 'id_jenis', 'id_jenis');
    }
}

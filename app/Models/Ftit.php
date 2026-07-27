<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ftit extends Model
{
    protected $table = 'ftit';
    protected $primaryKey = 'id_ftit';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'id_ftit',
        'nama_ftit',
    ];

    public function detailPemakaians()
    {
        return $this->hasMany(DetailPemakaian::class, 'id_ftit', 'id_ftit');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';
    protected $primaryKey = 'id_verifikasi';

    protected $fillable = [
        'id_user',
        'id_logbook',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function logbook()
    {
        return $this->belongsTo(Logbook::class, 'id_logbook', 'id_logbook');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPengisian extends Model
{
    protected $table = 'status_pengisian';
    protected $primaryKey = 'id_status';
    public $timestamps = false;

    protected $fillable = [
        'nama_status',
    ];

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'id_status', 'id_status');
    }
}

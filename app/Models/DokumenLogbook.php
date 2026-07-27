<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenLogbook extends Model
{
    protected $table = 'dokumen_logbook';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_user',
        'kode_vessel',
        'tanggal_logbook',
        'file_path',
        'nama_file_original',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kode_vessel', 'kode_vessel');
    }
}

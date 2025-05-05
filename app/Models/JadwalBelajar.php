<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBelajar extends Model
{
    protected $table = 'jadwal_belajar';
    
    
    protected $fillable = [
        'id',
        'user_id',
        'nama_mapel',
        'hari',
        'jam',
        'tanggal', 
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}

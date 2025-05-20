<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = "articles";

    protected $fillable = [
        'type',
        'judul',
        'tanggal_terbit',
        'deskripsi',
        'image'
    ];

    public function scopeMotivasi($query)
    {
        return $query->where('type', 'motivasi');
    }

    
    
}

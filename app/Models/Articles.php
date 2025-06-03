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

     public function scopePendidikan($query)
    {
        return $query->where('type', 'pendidikan'); 
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        });
    }
    
}

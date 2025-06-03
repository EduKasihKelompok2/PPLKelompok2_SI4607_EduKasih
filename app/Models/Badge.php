<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $table = 'badge';

    protected $fillable = [
        'name',
        'icon',
        'requirement',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badge');
    }
}

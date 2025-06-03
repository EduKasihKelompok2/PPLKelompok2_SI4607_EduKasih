<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'badge_id',
    ];

    
    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'claimed_rewards')
            ->withTimestamps();
    }

    public function scopeFilter(Builder $query, ?string $search = null)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Scholarship extends Model
{
    protected $fillable = [
        'name',
        'registration_start',
        'registration_end',
        'description',
        'thumbnail',
    ];
    protected $casts = [
        'registration_start' => 'date',
        'registration_end' => 'date',
    ];
    public function getFormattedRegistrationStartAttribute()
    {
        return $this->registration_start->format('d F Y');
    }
    public function getFormattedRegistrationEndAttribute()
    {
        return $this->registration_end->format('d F Y');
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

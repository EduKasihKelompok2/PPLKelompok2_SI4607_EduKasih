<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'accreditation',
        'city',
        'province',
        'founded_year',
        'status',
        'students',
        'image',
        'description',
        'address',
        'website',
        'instagram',
        'contact'
    ];

    /**
     * Get the faculties for the school.
     */
    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    /**
     * Scope a query to filter schools based on search query.
     */
    public function scopeFilter(Builder $query, ?string $search = null)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}

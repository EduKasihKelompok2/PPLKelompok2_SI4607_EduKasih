<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'programs'
    ];

    /**
     * Get the school that owns the faculty.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

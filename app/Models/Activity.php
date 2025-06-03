<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activity";

    protected $fillable = [
        'description',
        'user_id',
    ];

    public function saveActivity($description)
    {
        $this->create([
            'description' => $description,
            'user_id' => auth()->id(),
        ]);
    }

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('description', 'like', '%' . request('search') . '%');
        }
    }
}

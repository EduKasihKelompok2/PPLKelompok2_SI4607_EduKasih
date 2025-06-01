<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory;

    protected $table = "forum";

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_feedback',
        'forum_id',
        'image',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function feedback()
    {
        return $this->hasMany(Forum::class, 'forum_id')->where('is_feedback', true)->orderBy('created_at');
    }

    
    public function scopeMainPosts($query)
    {
        return $query->whereNull('forum_id')->orWhere('is_feedback', false);
    }

    
    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}

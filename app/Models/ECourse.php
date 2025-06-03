<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ECourse extends Model
{
    protected $table = 'e_course';
    protected $fillable = [
        'course_code',
        'course_name',
        'nama_mapel',
        'description',
        'rating',
        'image',
    ];

    public function courseVideos()
    {
        return $this->hasMany(CourseVideo::class, 'course_code', 'course_code');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'course_id');
    }

    public function getCourseVideos()
    {
        return $this->courseVideos()->orderBy('order', 'asc')->get();
    }

    public function getCourseVideoById($id)
    {
        return $this->courseVideos()->where('id', $id)->first();
    }

    public function getTotalDuration()
    {
        return $this->courseVideos()->sum('duration');
    }

    public function getTotalVideos()
    {
        return $this->courseVideos()->count();
    }

    
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('nama_mapel', 'like', "%{$category}%");
        }
        return $query;
    }

    
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('course_name', 'like', "%{$keyword}%")
                    ->orWhere('nama_mapel', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
}
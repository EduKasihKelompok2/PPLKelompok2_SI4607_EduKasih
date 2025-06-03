<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    protected $fillable = [
        'course_code',
        'title',
        'video_url',
        'duration',
        'order',
    ];

    public function eCourse()
    {
        return $this->belongsTo(ECourse::class, 'course_code', 'course_code');
    }

    // Extract YouTube video ID from various URL formats
    public function getYoutubeEmbedUrl()
    {
        $videoId = null;

        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $this->video_url, $match)) {
            $videoId = $match[1];
        } elseif (preg_match('/youtu\.be\/([^?]+)/', $this->video_url, $match)) {
            $videoId = $match[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^?]+)/', $this->video_url, $match)) {
            $videoId = $match[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return null;
    }
}

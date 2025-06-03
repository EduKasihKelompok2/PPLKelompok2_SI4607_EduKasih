<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExamSession extends Model
{
  protected $fillable = [
    'user_id',
    'exam_id',
    'started_at',
    'ends_at',
    'completed_at',
    'current_question',
    'score',
    'is_completed'
  ];

  protected $casts = [
    'started_at' => 'datetime',
    'ends_at' => 'datetime',
    'completed_at' => 'datetime',
    'is_completed' => 'boolean'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }

  public function answers()
  {
    return $this->hasMany(ExamAnswer::class);
  }

  public function getRemainingTimeAttribute()
  {
    if ($this->is_completed) {
      return 0;
    }

    $now = Carbon::now();
    if ($now > $this->ends_at) {
      return 0;
    }

    return $now->diffInSeconds($this->ends_at);
  }

  public function getRemainingTimeFormattedAttribute()
  {
    $seconds = $this->remaining_time;
    $minutes = floor($seconds / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d', $minutes, $seconds);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
  protected $fillable = ['course_id', 'title', 'duration_minutes'];

  public function course()
  {
    return $this->belongsTo(ECourse::class, 'course_id');
  }

  public function questions()
  {
    return $this->hasMany(ExamQuestion::class)->orderBy('order');
  }

  public function sessions()
  {
    return $this->hasMany(ExamSession::class);
  }
}

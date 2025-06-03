<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
  protected $fillable = [
    'exam_session_id',
    'exam_question_id',
    'selected_answer',
    'is_correct'
  ];

  protected $casts = [
    'is_correct' => 'boolean'
  ];

  public function session()
  {
    return $this->belongsTo(ExamSession::class, 'exam_session_id');
  }

  public function question()
  {
    return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
  }
}

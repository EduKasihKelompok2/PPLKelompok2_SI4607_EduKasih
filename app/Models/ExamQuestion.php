<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
  protected $fillable = [
    'exam_id',
    'question',
    'image_path',
    'answer_a',
    'answer_b',
    'answer_c',
    'answer_d',
    'correct_answer',
    'order'
  ];

  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }

  public function answers()
  {
    return $this->hasMany(ExamAnswer::class);
  }
}
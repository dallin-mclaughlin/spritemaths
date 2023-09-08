<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
      'quiz_id',
      'blurb',
      'question',
      'submitted_answer',
      'correct_answer',
      'solution_logic'
    ];
}

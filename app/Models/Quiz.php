<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionAnswer;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'quizs';

    protected $fillable = [
      'user_id',
      'title'
    ];

    protected $casts = [
      'updated_at' => 'datetime:d-m-Y'
    ];


    /**
     * Get the questions and answers for the quiz.
     */
    public function questionanswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }
} 

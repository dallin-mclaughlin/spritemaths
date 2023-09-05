<?php

namespace App\Questions\Basic\Arithmetic;

use App\Questions\Question;

class Multiplication extends Question {
  function __construct() {
    $min = 0;
    $max = 12;

    $firstNumber = random_int($min, $max);
    $secondNumber = random_int($min, $max);

    $question = '\\('.$firstNumber.'\\times'.$secondNumber.'\\)';
    $answer = strval($firstNumber * $secondNumber);

    $this->setQuestion($question);
    $this->setAnswer($answer);
  }
}
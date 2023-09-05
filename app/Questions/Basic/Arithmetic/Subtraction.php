<?php

namespace App\Questions\Basic\Arithmetic;

use App\Questions\Question;

class Subtraction extends Question {
  function __construct() {
    $min = 0;
    $max = 25;

    $firstNumber = random_int($min, $max);
    $secondNumber = random_int($min, $max);

    $question = '\\('.$firstNumber.'-'.$secondNumber.'\\)';
    $answer = strval($firstNumber - $secondNumber);

    $this->setQuestion($question);
    $this->setAnswer($answer);
  }
}
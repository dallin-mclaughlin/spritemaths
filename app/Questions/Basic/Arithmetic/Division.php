<?php

namespace App\Questions\Basic\Arithmetic;

use App\Questions\Question;

class Division extends Question {
  function __construct() {
    $min = 0;
    $max = 12;

    //dividend/divisor = quotient

    $divisor = random_int(1, $max);
    $quotient = random_int($min, $max);
    $dividend = $quotient * $divisor;

    $question = '\\('.$dividend.'\\div'.$divisor.'\\)';
    $answer = strval($quotient);

    $this->setQuestion($question);
    $this->setAnswer($answer);
  }
}
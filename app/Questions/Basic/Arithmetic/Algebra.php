<?php

namespace App\Questions\Basic\Arithmetic;

use App\Questions\Question;

class Algebra extends Question {

  // Solve for x given 2x + 5 = 1
  // Solve for x given ax + b = c
  // x = (c - b)/a
  function __construct() {
    $min = 1;
    $max = 8;

    $a = random_int($min, $max);
    $b = random_int($min, $max);
    $c = random_int($min, $max);

    $variable = "x";
    $term1 = ($a != 1) ? $a.$variable : $variable;
    $term2 = $b;
    $term3 = $c; 

    $question = "Solve for \\(".$variable."\\) given \\(".$term1."+".$term2."=".$term3."\\)";
    $answer = $this->float2rat(($c - $b)/$a);

    $this->setQuestion($question);
    $this->setAnswer($answer);
  }
}
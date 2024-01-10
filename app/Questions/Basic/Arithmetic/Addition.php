<?php

namespace App\Questions\Basic\Arithmetic;

use App\Questions\Question;

class Addition extends Question {
  function __construct() {
    $min = 0;
    $max = 25;

    $firstNumber = random_int($min, $max);
    $secondNumber = random_int($min, $max);

    $firstTen = intdiv($firstNumber, 10) * 10;
    $secondTen = intdiv($secondNumber, 10) * 10;
    $totalTen = $firstTen + $secondTen;

    $firstOne= $firstNumber - $firstTen;
    $secondOne = $secondNumber - $secondTen;
    $totalOne = $firstOne + $secondOne;

    $answerNumber = $firstNumber + $secondNumber;

    $question = '\\('.$firstNumber.'+'.$secondNumber.'\\)';
    $answer = strval($answerNumber);

    //todo: if there are no tens to add then remove this line
    $tens = "10s: & $firstTen+$secondTen  = & $totalTen \\\ ";

    $solution_logic = "
    \begin{align}
      10s: & $firstTen+$secondTen  = & $totalTen \\\
      1s: & $firstOne+$secondOne  = & + $totalOne \\\
      &  &   \\enclose{top}{ $answerNumber } \\\
    \\end{align}
    ";

  $num = random_int(2,4);

  $graph_data = array(
    'target' => '#root',
    'width' => 800,
    'height' => 500,
    'yAxis' => array('domain'=>[-1,9]),
    'grid'=>true,
    'disableZoom'=>true,
    'data'=> [array('fn'=>$num.'x^2', 'skipTip'=>true)] 
  );

    $this->setQuestion($question);
    $this->setAnswer($answer);
    $this->setSolutionLogic($solution_logic);
    (random_int(0,1))?$this->setGraphData(json_encode($graph_data)):$this->setGraphData('{}');
  }
}
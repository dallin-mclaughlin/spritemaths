<?php

namespace App\Questions;

class Question {

  private $blurb;
  private $question;
  private $answer;
  private $solution_logic = 'No solution logic has been provided yet';
  private $graph_data = '{}';

  function setBlurb($blurb){
    $this->blurb = $blurb;
  }

  function setGraphData($graph_data){
    $this->graph_data = $graph_data;
  }

  function setSolutionLogic($solution_logic){
    $this->solution_logic = $solution_logic;
  }

  function setQuestion($question){
    $this->question = $question;
  }

  function setAnswer($answer){
    $this->answer = $answer;
  }

  function getBlurb(){
    return $this->blurb;
  }

  function getQuestion(){
    return $this->question;
  }

  function getAnswer(){
    return $this->answer;
  }

  function getSolutionLogic(){
    return $this->solution_logic;
  }

  function getGraphData(){
    return $this->graph_data;
  }

  function float2rat($n, $latexFormat = true, $tolerance = 1.e-6) {
    $negative = false;
    if($n < 0){
        $n = $n * (-1);
        $negative = true;
    }
    if($n == 0) return "0";
    $h1=1; $h2=0;
    $k1=0; $k2=1;
    $b = 1/$n;
    do {
        $b = 1/$b;
        $a = floor($b);
        $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
        $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
        $b = $b-$a;
    } while (abs($n-$h1/$k1) > $n*$tolerance);

    if($latexFormat){   
        if($negative){
            if($k1 == 1){
                return '-'.$h1;
            }
            return "-\\frac{".$h1."}{".$k1."}";
        } else {
            if($k1 == 1){
                return $h1;
            }
            return "\\frac{".$h1."}{".$k1."}";
        }
    } else {
        return "$h1/$k1";
    }
}
}
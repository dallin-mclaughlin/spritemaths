<?php

namespace App\Questions;

class Question {

  private $question;
  private $answer;

  function setQuestion($question){
    $this->question = $question;
  }

  function setAnswer($answer){
    $this->answer = $answer;
  }

  function getQuestion(){
    return $this->question;
  }

  function getAnswer(){
    return $this->answer;
  }

  function float2rat($n, $latexFormat = True, $tolerance = 1.e-6) {
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
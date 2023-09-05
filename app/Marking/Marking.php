<?php

namespace App\Marking;

use MathParser\ComplexMathParser;
use MathParser\Interpreting\ComplexEvaluator;
use MathParser\Extensions\Complex;
use Illuminate\Support\Facades\Log;


class Marking {

  //Different types of answers
  //1. [X] Single answer e.g. 12.1, 2x + 3, -\\frac{2}{3}
  //2. [ ] Single Equation answer e.g. y = 3x + 2
  //3. [ ] Single inequation e.g. x < 5 or x > 5 or x >= 5
  //4. [ ] List of single answers e.g. {5, x, 2x + 3, e^{2}}

  public static function markAnswer($submittedAnswer, $correctAnswer)
  {
    if($submittedAnswer == NULL) return false;

    $iterants = 5;
    $decimalPointAccuracy = 13;
    $epsilon = 0.000000001;
    $iterations = array();
    for($i = 0; $i < $iterants; $i++){
        // random real numbers [1.01,1.99]
        $iterations[] = random_int(101,199)/100;
    }


    preg_match_all('/[a-zA-Z]/', $submittedAnswer, $matches_sub);
    preg_match_all('/[a-zA-Z]/', $correctAnswer, $matches_cor);

    $variables = array_unique(array_merge($matches_sub[0], $matches_cor[0]));

    $parser = new ComplexMathParser();

    $correct = true;

    $correctAnswer = Static::parseAnswer($correctAnswer);
    $submittedAnswer = Static::parseAnswer($submittedAnswer);

    for($i = 0; $i < count($iterations); $i++){
      $answerMap = array();

      try {
        $correctAnswer = $parser->parse($correctAnswer);
        $submittedAnswer = $parser->parse($submittedAnswer);
      } catch (\Exception $e)
      {
        Log::error($e);
        return false;
      }


      for($j=0;$j<count($variables);$j++)
      {
          $answerMap[$variables[$j]] = $iterations[($i+$j)%count($iterations)];
      }

      $evaluator = new ComplexEvaluator($answerMap);

      try {
        $correctAnswerValue = $correctAnswer->accept($evaluator);
        $submittedAnswerValue = $submittedAnswer->accept($evaluator);
      } catch (\Exception $e){
        Log::error($e);
        return false;
      }

      //Make sure they are always complex for the algorithm to work!
      if(is_numeric($correctAnswerValue)){
          $correctAnswerValue = new Complex($correctAnswerValue, 0);
      }

      if(is_numeric($submittedAnswerValue)){
          $submittedAnswerValue = new Complex($submittedAnswerValue,0);
      }

      if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))>$epsilon || abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))>$epsilon){
          $correct = false;
      }
    }

    return $correct;

  }

  public static function parseAnswer($answer)
  {
    $answer = Static::replaceLatexFrac($answer);
    $answer = Static::replaceLatexSqrt($answer);

    $replacements = ["\\cdot"=>"*", "\\left("=>"(", "\\right)"=>")",
                      "}{"=>")/(", "\\frac{"=>"(", "}"=>")",
                      "^{"=>"^(", "\\pi"=>"pi", "\\sqrt{"=>"sqrt(",
                      "\\exp"=>"exp", "\\sin"=>"sin", "\\cos"=>"cos",
                      "\\tan"=>"tan", "+-"=>"-"];
    $arrayvalues = array_values($replacements);
    $arraykeys = array_keys($replacements);

    $parsedAnswer = str_replace($arraykeys, $arrayvalues, $answer);
    //for the case where \frac12 is outputed instead of \frac{1}{2}
    //so while there exists \frac in the submitted answer
    //    /\frac[0-9]{2}/  \frac{$0}{$1}

    $parsedAnswer = Static::divideByNegative($parsedAnswer);

    return $parsedAnswer;
  }

  public static function divideByNegative($answer){
    //two cases
    //1. brackets in numerator
    //2. no brackets in numerator
    if (strpos($answer,")/-")){
        $lastBracketPos = 0;
        $count = 1;
        $divPos = strpos($answer,")/-");
        $index = $divPos;
        do {
            $index--;
            if($answer[$index]==')'){
                $count++;
            } else if ($answer[$index]=='('){
                $count--;
            }
        } while ($index >= 0 && $count != 0);
        $lastBracketPos = $index;
        $answerNoMinus = str_replace("/-","/",$answer);
        $answerNoMinus = substr($answerNoMinus,0,$lastBracketPos).'-'.substr($answerNoMinus,$lastBracketPos);
        return Static::divideByNegative($answerNoMinus);

    } else if (strpos($answer,"/-")){
        $op = '';
        $divPos = strpos($answer,"/-");
        $index = $divPos;
        do {
            $index--;
            if($answer[$index]=="+"||$answer[$index]=="-"||$answer[$index]=="*"){
                $op = $answer[$index];
            }
        } while ($index >= 0 && $op=='');
        $lastPos = $index;
        if($op == "+"){
            $answerNoMinus = str_replace("/-","/",$answer);
            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'-'.substr($answerNoMinus,$lastPos+1);
            return Static::divideByNegative($answerNoMinus);
        } else if($op == "-"){
            $answerNoMinus = str_replace("/-","/",$answer);
            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'+'.substr($answerNoMinus,$lastPos+1);
            return Static::divideByNegative($answerNoMinus);
        } else if($op == "*"){
            $answerNoMinus = str_replace("/-","/",$answer);
            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'*-'.substr($answerNoMinus,$lastPos+1);
            return Static::divideByNegative($answerNoMinus);
        } else {
            $answerNoMinus = str_replace("/-","/",$answer);
            $answerNoMinus = '-'.substr($answerNoMinus,0);
            return Static::divideByNegative($answerNoMinus);
        }
    } else {
        return $answer;
    }
  }

  public static function replaceLatexFrac($string) {
    $pattern = '/\\\frac[0-9]{2}/';
    preg_match_all($pattern, $string, $matches);
    foreach($matches[0] as $match)
    {
      $numerator = substr($match,-2,1);
      $denominator = substr($match,-1);
      $pattern = "\\frac".$numerator.$denominator;
      $replace = "(".$numerator."/".$denominator.")";
      $string = str_replace($pattern, $replace, $string);
    }
    return $string;
  }

  public static function replaceLatexSqrt($string) {
    $pattern = '/\\\sqrt[0-9]{1}/';
    preg_match_all($pattern, $string, $matches);
    foreach($matches[0] as $match)
    {
      $number = substr($match,-1);
      $pattern = "\\sqrt".$number;
      $replace = "sqrt(".$number.")";
      $string = str_replace($pattern, $replace, $string);
    }
    return $string;
  }
}

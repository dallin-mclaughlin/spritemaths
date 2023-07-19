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
}
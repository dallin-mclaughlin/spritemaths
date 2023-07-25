<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class Hey {
  public function sayZ() {
    return 'y';
  }
}
//this makes my life so simple right now! Yes baby!

class QuizController extends Controller
{

    private int $num_questions = 10;
    /**
     * Create a quiz for a given user
     */
    public function create() : Response
    {
      //grab id from the button pressed to know what php script to run
      $num = $this->num_questions;
      $questions = [];
      $submitted_answers = [];
      $answers = [];
      $type = 'App\Questions\Basic\Arithmetic\Addition';
      for($i = 0; $i < $num; $i++){
        $object = new $type;
        array_push($questions, $object->getQuestion());
        array_push($answers, $object->getAnswer());
        array_push($submitted_answers, '');
      }

      return Inertia::render('Quiz',[
        'Questions'=> $questions,
        'SubmittedAnswers'=> $submitted_answers
      ]);
    }
}


<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
 

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
      $titles = [];
      $address = [];

      foreach(Question::all() as $question) {
        array_push($address, $question->name_space);
        array_push($titles, $question->title);
      }

      $type = "App\Questions\\".$address[array_rand($address)];
      for($i = 0; $i < $num; $i++){
        $object = new $type;
        array_push($questions, $object->getQuestion());
        array_push($answers, $object->getAnswer());
        array_push($submitted_answers, '');
      }

      return Inertia::render('Quiz',[
        'Questions'=> $questions,
        'SubmittedAnswers'=> $submitted_answers,
        'Titles'=>$titles
      ]);
    }
}


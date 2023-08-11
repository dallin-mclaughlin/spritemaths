<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
 

class QuizController extends Controller
{

    private int $num_questions = 10;

    /**
     * Create new quiz data
     */
    private function createNewQuiz(string $question_id) : array
    {
      $questions = [];
      $submitted_answers = [];

      $questionObject = Question::where('id', $question_id)->first();

      $quiz = Quiz::create([
        'user_id'=>Auth::id(),
        'title'=>$questionObject->title
      ]);

      $type = "App\Questions\\".$questionObject->name_space;
      for($i = 0; $i < $this->num_questions; $i++){
        $object = new $type;
        $question_answer = new QuestionAnswer([
          'question'=>$object->getQuestion(),
          'correct_answer'=>$object->getAnswer()
        ]);
        $quiz->questionanswers()->save($question_answer);
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
      }

      return [$questions, $submitted_answers, $quiz->id];
    }

    /**
     * Retrieve saved quiz data
     */
    private function retrieveSavedQuiz(string $quiz_id) : array
    {
      $questions = [];
      $submitted_answers = [];
      
      $quiz_id = $quiz_id;

      $questions_answers = Quiz::find($quiz_id)->questionanswers;

      foreach($questions_answers as $question_answer){
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
      }

      return [$questions, $submitted_answers, $quiz_id];
    }

     /**
     * Get quiz and display it
     */
    public function index(Request $request) : Response
    {
      $id = $request->input('id');
      $is_new_quiz = $request->input('newquiz');

      $questions = [];
      $submitted_answers = [];
      $quiz_id = null;

      if($is_new_quiz) {
        [ 
          $questions, 
          $submitted_answers, 
          $quiz_id
        ] = $this->createNewQuiz($id);
      } else {
        [
          $questions, 
          $submitted_answers, 
          $quiz_id
        ] = $this->retrieveSavedQuiz($id);
      }

      if($quiz_id == null) redirect()->back();

      return Inertia::render('Quiz', 
        [
          'ID'=>$quiz_id, 
          'Questions'=>$questions, 
          'SubmittedAnswers'=>$submitted_answers
        ]);
    }

    /**
     * Save Quiz
     */
    public function save(Request $request): RedirectResponse
    {
      $quiz_id = $request->input('id');
      $submitted_answers = $request->input('submittedanswers');
      $questions_answered = 0;

      $quiz = Quiz::find($quiz_id);

      for($i = 0; $i < count($submitted_answers); $i++){
        $quiz->questionanswers[$i]->submitted_answer = $submitted_answers[$i];
        if($submitted_answers[$i] != null && $submitted_answers[$i] != '') $questions_answered++;
      }

      $quiz->percentage_complete = round(100 * $questions_answered/count($submitted_answers));
      $quiz->push();

      return redirect('dashboard')->banner('Quiz Saved successfully');
    }
}


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
use Illuminate\Support\Facades\DB;

use MathParser\ComplexMathParser;
use MathParser\Interpreting\ComplexEvaluator;
use MathParser\Interpreting\Differentiator;
use App\Marking\Marking;
 

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

      $questions_answers = Quiz::find($quiz_id)->questionanswers;

      foreach($questions_answers as $question_answer){
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
      }

      return [$questions, $submitted_answers, $quiz_id];
    }

    private function saveQuiz(string $quiz_id, array $submitted_answers): void
    {
      $questions_answered = 0;

      $quiz = Quiz::find($quiz_id);

      //before updating data check that the questionanswers exists

      // print_r($quiz->questionanswers);

      // if($quiz->questionanswers) 
      // {
      //   Quiz::destroy($quiz_id);
      //   return;
      // }


      for($i = 0; $i < count($submitted_answers); $i++){
        //check first that the input is acceptable, e.g. no SQL statements
        $quiz->questionanswers[$i]->submitted_answer = $submitted_answers[$i];
        if($submitted_answers[$i] != null && $submitted_answers[$i] != '') $questions_answered++;
      }

      $quiz->percentage_complete = round(100 * $questions_answered/count($submitted_answers));
      $quiz->push();
    }

     /**
     * Get quiz and display it
     */
    public function index(Request $request) : Response
    {
      //check to see if the person has more than 5 saved quizzes
      //if they do then prevent them from creating another quiz
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
      
      $this->saveQuiz($quiz_id, $submitted_answers);

      return redirect('dashboard')->banner('Quiz Saved successfully');
    }

    /**
     * Mark Quiz and display on Marking page
     */
    public function mark(Request $request): Response
    {
      //save the quiz
      $quiz_id = $request->input('id');
      $submitted_answers = $request->input('submittedanswers');
      $this->saveQuiz($quiz_id, $submitted_answers);
      //get the questions, correct answers and solution process
      $quiz = Quiz::find($quiz_id);
      //mark the quiz. What should the results data format be?
      //perhaps return an array containing booleans for correct
      //$results = $this->markQuiz($questionanswers);

      $questionanswers = $quiz->questionanswers;
      for($i = 0; $i < count($questionanswers); $i++)
      {
        $correctanswer = $questionanswers[$i]->correct_answer;
        $submittedanswer = $questionanswers[$i]->submitted_answer;
        $questionanswers[$i]->is_correct = Marking::markAnswer($submittedanswer, $correctanswer);
      }

      $quiz->push();

      return Inertia::render('Results', 
        [
          'Quiz'=>$quiz,
        ]);
    }

    /**
     * Delete Quiz
     */
    public function delete(Request $request): RedirectResponse
    {
      $quiz_id = $request->input('id');
      Quiz::destroy($quiz_id);
      DB::table('question_answers')->where('quiz_id', $quiz_id)->delete();
      return redirect('dashboard')->banner('Quiz Deleted successfully');
    }

    public function phpmathparser() 
    {
      $quiz = Quiz::find(7);
      $qs = Quiz::find(7)->questionanswers;
      return $qs;
      $questionanswers = $quiz->questionanswers;
      for($i = 0; $i < count($questionanswers); $i++)
      {
        $quiz->questionanswers[$i]->is_correct = true;
      }
      $quiz->push();
      $quiz = Quiz::find(7);
      $parser = new ComplexMathParser();
      $AST = $parser->parse('x + yi');
      $evaluator = new ComplexEvaluator([ 'x' => 1, 'y' => 2 ]);
      $value = $AST->accept($evaluator);
      return $quiz;
    }
}



//i think i might need to use the power of json objects better
//because here i am creating arrays that will be accesses using an 
//index


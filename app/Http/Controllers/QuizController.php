<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\Marking\Marking;
 

class QuizController extends Controller
{

    private int $num_questions = 10;

    /**
     * Create new quiz data
     */
    private function createNewMultipleQuiz(string $topic_id) : array
    {
      $blurbs = [];
      $questions = [];
      $submitted_answers = [];
      $graph_datas = [];

      $topic = Topic::where('id', $topic_id)->first();
      $questionObjects = Question::where('topic_id', $topic_id)
                        ->get()
                        ->random(fn (Collection $items) => 
                            min($this->num_questions, count($items)))
                        ->shuffle();

      if(count($questionObjects)==0) return [null, null, null, null, null];

      $quiz = Quiz::create([
        'user_id'=>Auth::id(),
        'title'=>$topic->topic
      ]);

      for($i = 0; $i < count($questionObjects); $i++){
        $questionObject = $questionObjects[$i];
        $type = "App\Questions\\".$questionObject->name_space;
        $object = new $type;
        $question_answer = new QuestionAnswer([
          'blurb'=>$object->getBlurb(),
          'question'=>$object->getQuestion(),
          'correct_answer'=>$object->getAnswer(),
          'solution_logic'=>$object->getSolutionLogic(),
          'graph_data'=>$object->getGraphData()
        ]);
        $quiz->questionanswers()->save($question_answer);
        array_push($blurbs, $question_answer->blurb);
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
        array_push($graph_datas, $question_answer->graph_data);
      }
      

      return [$blurbs, $questions, $submitted_answers, $graph_datas, $quiz->id];
    }

    /**
     * Create new quiz data
     */
    private function createNewQuiz(string $question_id) : array
    {
      $blurbs = [];
      $questions = [];
      $submitted_answers = [];
      $graph_datas = [];

      $questionObject = Question::where('id', $question_id)->first();

      if($questionObject->id == null) return [null, null, null, null, null];

      $quiz = Quiz::create([
        'user_id'=>Auth::id(),
        'title'=>$questionObject->title
      ]);

      $type = "App\Questions\\".$questionObject->name_space;
      for($i = 0; $i < $this->num_questions; $i++){
        $object = new $type;
        $question_answer = new QuestionAnswer([
          'blurb'=>$object->getBlurb(),
          'question'=>$object->getQuestion(),
          'correct_answer'=>$object->getAnswer(),
          'solution_logic'=>$object->getSolutionLogic(),
          'graph_data'=>$object->getGraphData()
        ]);
        $quiz->questionanswers()->save($question_answer);
        array_push($blurbs, $question_answer->blurb);
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
        array_push($graph_datas, $question_answer->graph_data);
      }

      return [$blurbs, $questions, $submitted_answers, $graph_datas, $quiz->id];
    }

    /**
     * Retrieve saved quiz data
     */
    private function retrieveSavedQuiz(string $quiz_id) : array
    {
      $blurbs = [];
      $questions = [];
      $submitted_answers = [];
      $graph_datas = [];

      $questions_answers = Quiz::find($quiz_id)->questionanswers;

      foreach($questions_answers as $question_answer){
        array_push($blurbs, $question_answer->blurb);
        array_push($questions, $question_answer->question);
        array_push($submitted_answers, $question_answer->submitted_answer);
        array_push($graph_datas, $question_answer->graph_data);
      }

      return [$blurbs, $questions, $submitted_answers, $graph_datas, $quiz_id];
    }

    private function saveQuiz(string $quiz_id, array $submitted_answers): void
    {
      $questions_answered = 0;

      $quiz = Quiz::find($quiz_id);

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
    public function index(Request $request)
    {
      $id = $request->input('id');
      $is_new_quiz = $request->input('newquiz');
      $is_multiple = $request->input('multiple');
      //check to see if the person has more than 5 saved quizzes
      //if they do then prevent them from creating another quiz
      if($is_new_quiz && DB::table('quizs')->where('user_id', Auth::id())->count()>4){
        return redirect('dashboard')->dangerBanner('Before starting another quiz finish one first please.');
      }

      [ 
        $blurbs,
        $questions, 
        $submitted_answers, 
        $graph_datas,
        $quiz_id
      ] = [null, null, null, null, null]; 
      
      if($is_new_quiz && !$is_multiple){
        [ 
          $blurbs,
          $questions, 
          $submitted_answers, 
          $graph_datas,
          $quiz_id
        ] = $this->createNewQuiz($id);
      } else if($is_new_quiz && $is_multiple){
        [ 
          $blurbs,
          $questions, 
          $submitted_answers, 
          $graph_datas,
          $quiz_id
        ] = $this->createNewMultipleQuiz($id);
      } else {
        [ 
          $blurbs,
          $questions, 
          $submitted_answers, 
          $graph_datas,
          $quiz_id
        ] = $this->retrieveSavedQuiz($id);
      }

      if($quiz_id == null) return redirect('dashboard')->dangerBanner('An error occured. Try again.');

      return Inertia::render('Quiz', 
        [
          'ID'=>$quiz_id, 
          'Blurbs'=>$blurbs,
          'GraphDatas'=>$graph_datas,
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
}



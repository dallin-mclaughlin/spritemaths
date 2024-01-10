<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(): Response
    {
      $questions = Question::all();
      $topics = Topic::all();
      $quizs = Quiz::where('user_id', Auth::id())->get();
      
      return Inertia::render('Dashboard',[
        'questions'=>$questions,
        'topics'=>$topics,
        'quizs'=>$quizs
      ]);
    }
}

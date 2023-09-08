<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\MarkingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/theory', function () {
  return Inertia::render('Theory');
})->name('theory');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/quiz', function() {
      return redirect()->route('dashboard');
    });
    Route::post('/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::post('/quiz/save', [QuizController::class, 'save'])->name('quiz.save');
    Route::post('/quiz/delete', [QuizController::class, 'delete'])->name('quiz.delete');
    Route::post('/quiz/mark', MarkingController::class)->name('quiz.mark');

    Route::get('/results', function() {
      return redirect()->route('dashboard');
    });
    Route::post('/results', [QuizController::class, 'mark'])->name('quiz.results');
});


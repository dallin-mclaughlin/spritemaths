<?php

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/quiz', function () {
      return Inertia::render('Quiz',[
        'Questions'=> [
          'Differentiate \\(x\\)',
          'Differentiate \\(2x\\)',
          'Differentiate \\(3x\\)',
          'Differentiate \\(4x\\)',
          'Differentiate \\(5x\\)',
          'Differentiate \\(6x\\)'
        ],
        'SubmittedAnswers'=>[
          '',
          '',
          '',
          '',
          '',
          ''
        ]
      ]);
    })->name('quiz');
    Route::get('/theory', function () {
      return Inertia::render('Theory');
    })->name('theory');
});


<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AttemptController;

Route::get('/', [QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');

Route::post('/quizzes/{quiz}/attempts', [AttemptController::class, 'start'])->name('attempts.start');
Route::get('/attempts/{attempt}/take', [AttemptController::class, 'take'])->name('attempts.take');
Route::post('/attempts/{attempt}/submit', [AttemptController::class, 'submit'])->name('attempts.submit');
Route::get('/attempts/{attempt}/result', [AttemptController::class, 'result'])->name('attempts.result');
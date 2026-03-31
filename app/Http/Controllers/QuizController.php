<?php
namespace App\Http\Controllers;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller {
    public function index() {
        $quizzes = Quiz::latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }
    public function create() {
        return view('quizzes.create');
    }
    public function store(Request $request) {
        $request->validate(['title' => 'required|string|max:255']);
        $quiz = Quiz::create($request->only('title','description'));
        return redirect()->route('quizzes.show', $quiz)->with('success', 'Quiz created!');
    }
    public function show(Quiz $quiz) {
        $quiz->load('questions.options');
        return view('quizzes.show', compact('quiz'));
    }
}
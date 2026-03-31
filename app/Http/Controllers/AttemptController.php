<?php
namespace App\Http\Controllers;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Services\QuestionEvaluator;
use Illuminate\Http\Request;

class AttemptController extends Controller {
    public function start(Quiz $quiz) {
        $attempt = Attempt::create([
            'quiz_id'    => $quiz->id,
            'started_at' => now(),
        ]);
        return redirect()->route('attempts.take', $attempt);
    }

    public function take(Attempt $attempt) {
        $attempt->load('quiz.questions.options');
        return view('attempts.take', compact('attempt'));
    }

    public function submit(Request $request, Attempt $attempt) {
        $evaluator = new QuestionEvaluator();
        $totalScore = 0;

        foreach ($attempt->quiz->questions as $question) {
            $raw = $request->input('answers.' . $question->id);

            $attempt->answers()->create([
                'question_id' => $question->id,
                'value'       => is_array($raw) ? $raw : [$raw],
            ]);

            if ($question->type === 'multiple') {
                $answerValue = is_array($raw) ? $raw : [$raw];
            } else {
                $answerValue = is_array($raw) ? $raw[0] : $raw;
            }

            $result = $evaluator->evaluate($question, $answerValue);
            \Log::info('QUESTION SCORE', [
            'question_id' => $question->id,
            'type'        => $question->type,
            'answer'      => $answerValue,
            'score'       => $result,
            ]);
            $totalScore += $result;
        }

        $attempt->update([
            'submitted_at' => now(),
            'score'        => $totalScore,
        ]);

        return redirect()->route('attempts.result', $attempt);
    }
    
    public function result(Attempt $attempt) {
        $attempt->load('quiz.questions.options', 'answers');
        return view('attempts.result', compact('attempt'));
    }
}
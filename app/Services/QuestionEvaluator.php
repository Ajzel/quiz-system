<?php
namespace App\Services;
use App\Models\Question;

class QuestionEvaluator {
    public function evaluate(Question $question, mixed $answer): float {
        return match($question->type) {
            'binary'   => $this->evaluateBinary($question, $answer),
            'single'   => $this->evaluateSingle($question, $answer),
            'multiple' => $this->evaluateMultiple($question, $answer),
            'number'   => $this->evaluateNumber($question, $answer),
            'text'     => $this->evaluateText($question, $answer),
            default    => 0,
        };
    }

    private function evaluateBinary(Question $question, $answer): float {
        $correct = $question->options()->where('is_correct', true)->first();
        if (!$correct) return 0;
        return strtolower($answer) === strtolower($correct->text) ? $question->marks : 0;
    }

    private function evaluateSingle(Question $question, $answer): float {
        $correct = $question->options()->where('is_correct', true)->first();
        if (!$correct) return 0;
        return (string)$answer === (string)$correct->id ? $question->marks : 0;
    }

    private function evaluateMultiple(Question $question, $answer): float {
    $correctIds = $question->options()
        ->where('is_correct', true)
        ->pluck('id')
        ->map(fn($id) => (string)$id)
        ->sort()
        ->values()
        ->toArray();

    $given = collect(is_array($answer) ? $answer : [$answer])
        ->map(fn($id) => (string)$id)
        ->sort()
        ->values()
        ->toArray();

    \Log::info('MULTIPLE EVAL', [
        'correctIds' => $correctIds,
        'given'      => $given,
        'match'      => $correctIds === $given,
    ]);

    return $correctIds === $given ? $question->marks : 0;
    }

    private function evaluateNumber(Question $question, $answer): float {
        $correct = $question->options()->where('is_correct', true)->first();
        if (!$correct) return 0;
        return (float)$answer === (float)$correct->text ? $question->marks : 0;
    }

    private function evaluateText(Question $question, $answer): float {
        $correct = $question->options()->where('is_correct', true)->first();
        if (!$correct) return 0;
        return strtolower(trim($answer)) === strtolower(trim($correct->text)) ? $question->marks : 0;
    }
}
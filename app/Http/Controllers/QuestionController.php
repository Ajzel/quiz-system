<?php
namespace App\Http\Controllers;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller {
    public function create(Quiz $quiz) {
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz) {
        $request->validate([
            'type'  => 'required|in:binary,single,multiple,number,text',
            'body'  => 'required|string',
            'marks' => 'integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = $quiz->questions()->create([
            'type'      => $request->type,
            'body'      => $request->body,
            'marks'     => $request->marks ?? 1,
            'video_url' => $request->video_url,
            'image'     => $imagePath,
            'order'     => $quiz->questions()->count(),
        ]);

        // Save options
        if (in_array($request->type, ['binary','single','multiple','number','text'])) {
            $optionTexts   = $request->input('option_text', []);
            $optionImages  = $request->file('option_image', []);
            $correctFlags  = $request->input('is_correct', []);

            foreach ($optionTexts as $i => $text) {
                $optImgPath = null;
                if (!empty($optionImages[$i])) {
                    $optImgPath = $optionImages[$i]->store('options', 'public');
                }
                $question->options()->create([
                    'text'       => $text,
                    'image'      => $optImgPath,
                    'is_correct' => in_array($i, $correctFlags),
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question added!');
    }
}
@extends('layouts.app')
@section('content')
    <h3>Edit Question</h3>
    <form method="POST" action="{{ route('questions.update', [$quiz, $question]) }}">
        @csrf
        @method('PUT')

        <label>Question Body</label>
        <textarea name="body" rows="3" required>{{ $question->body }}</textarea>

        <label>Video URL (optional)</label>
        <input type="text" name="video_url" value="{{ $question->video_url }}">

        <label>Marks</label>
        <input type="number" name="marks" value="{{ $question->marks }}" min="1">

        <h4>Options</h4>
        <p style="color:#6b7280;font-size:0.85em">Check the box next to correct answer(s).</p>

        @foreach($question->options as $opt)
            <div style="border:1px solid #e5e7eb;padding:10px;margin-bottom:8px;border-radius:4px">
                <input type="text"
                       name="option_text[{{ $opt->id }}]"
                       value="{{ $opt->text }}"
                       {{ $question->type === 'binary' ? 'readonly' : '' }}
                       style="width:70%;display:inline-block;{{ $question->type === 'binary' ? 'background:#f3f4f6;' : '' }}">
                <label style="margin-left:10px">
                    <input type="checkbox"
                           name="is_correct[]"
                           value="{{ $opt->id }}"
                           {{ $opt->is_correct ? 'checked' : '' }}
                           {{ $question->type === 'binary' ? 'disabled' : '' }}>
                    Correct
                </label>
            </div>
        @endforeach

        {{-- Hidden inputs to preserve binary correct answer since disabled checkboxes don't submit --}}
        @if($question->type === 'binary')
            @foreach($question->options as $opt)
                @if($opt->is_correct)
                    <input type="hidden" name="is_correct[]" value="{{ $opt->id }}">
                @endif
            @endforeach
        @endif

        <br>
        <button type="submit" class="btn">Update Question</button>
        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-red" style="margin-left:8px">Cancel</a>
    </form>
@endsection
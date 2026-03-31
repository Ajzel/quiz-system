@extends('layouts.app')
@section('content')
    <h3>Result: {{ $attempt->quiz->title }}</h3>

    @php
        $total = $attempt->quiz->questions->sum('marks');
    @endphp

    <div class="card" style="text-align:center;font-size:1.4em">
        Score: <strong>{{ $attempt->score }} / {{ $total }}</strong>
    </div>

    <h4>Review</h4>
    @foreach($attempt->quiz->questions as $q)
        @php
            $ans = $attempt->answers->firstWhere('question_id', $q->id);
            $given = $ans ? (array)$ans->value : [];
        @endphp
        <div class="card">
            <p><strong>Q{{ $loop->iteration }}.</strong> {!! $q->body !!}</p>

            @if(in_array($q->type, ['single','multiple']))
                @php
                    $selectedOptions = $q->options->whereIn('id', $given);
                @endphp
                <p>Your answer: <em>{{ $selectedOptions->pluck('text')->join(', ') }}</em></p>
            @else
                <p>Your answer: <em>{{ implode(', ', $given) }}</em></p>
            @endif
        </div>
    @endforeach

    <a href="{{ route('quizzes.show', $attempt->quiz) }}" class="btn">Back to Quiz</a>
    <a href="/" class="btn" style="margin-left:8px">Home</a>
@endsection
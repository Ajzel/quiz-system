@extends('layouts.app')
@section('content')
    <h3>{{ $quiz->title }}</h3>
    <p>{{ $quiz->description }}</p>

    <a href="{{ route('questions.create', $quiz) }}" class="btn">+ Add Question</a>

    <form method="POST" action="{{ route('attempts.start', $quiz) }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-green" style="margin-left:8px">▶ Start Quiz</button>
    </form>

    <br><br>
    <h4>Questions ({{ $quiz->questions->count() }})</h4>
    @forelse($quiz->questions as $q)
        <div class="card">
            <strong>[{{ strtoupper($q->type) }}]</strong> {!! $q->body !!}
            @if($q->image)
                <br><img src="{{ asset('storage/'.$q->image) }}" style="max-height:100px;margin-top:8px">
            @endif
            @if($q->video_url)
                <br><a href="{{ $q->video_url }}" target="_blank">📹 Video</a>
            @endif
            <p style="color:#6b7280;font-size:0.85em">Marks: {{ $q->marks }} | Options: {{ $q->options->count() }}</p>
        </div>
    @empty
        <p>No questions yet.</p>
    @endforelse
@endsection
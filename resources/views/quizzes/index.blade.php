@extends('layouts.app')
@section('content')
    <h3>All Quizzes</h3>
    <a href="{{ route('quizzes.create') }}" class="btn">+ Create Quiz</a>
    <br><br>
    @forelse($quizzes as $quiz)
        <div class="card">
            <strong>{{ $quiz->title }}</strong>
            <p>{{ $quiz->description }}</p>
            <a href="{{ route('quizzes.show', $quiz) }}" class="btn">View</a>
        </div>
    @empty
        <p>No quizzes yet.</p>
    @endforelse
@endsection
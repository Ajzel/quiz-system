@extends('layouts.app')
@section('content')
    <h3>Create Quiz</h3>
    <form method="POST" action="{{ route('quizzes.store') }}">
        @csrf
        <label>Title</label>
        <input type="text" name="title" required>
        <label>Description</label>
        <textarea name="description" rows="3"></textarea>
        <button type="submit" class="btn">Create Quiz</button>
    </form>
@endsection
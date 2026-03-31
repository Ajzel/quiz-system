@extends('layouts.app')
@section('content')
    <h3>{{ $attempt->quiz->title }}</h3>
    <form method="POST" action="{{ route('attempts.submit', $attempt) }}">
        @csrf
        @foreach($attempt->quiz->questions as $q)
            <div class="card">
                <p><strong>Q{{ $loop->iteration }}.</strong> {!! $q->body !!} <span style="color:#6b7280">({{ $q->marks }} mark{{ $q->marks > 1 ? 's' : '' }})</span></p>

                @if($q->image)
                    <img src="{{ asset('storage/'.$q->image) }}" style="max-height:150px;margin-bottom:8px">
                @endif
                @if($q->video_url)
                    <p><a href="{{ $q->video_url }}" target="_blank">📹 Watch Video</a></p>
                @endif

                @if($q->type === 'binary')
                    <label><input type="radio" name="answers[{{ $q->id }}]" value="yes"> Yes</label>&nbsp;
                    <label><input type="radio" name="answers[{{ $q->id }}]" value="no"> No</label>

                @elseif($q->type === 'single')
                    @foreach($q->options as $opt)
                        <label><input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}">
                            {{ $opt->text }}
                            @if($opt->image)<img src="{{ asset('storage/'.$opt->image) }}" style="max-height:60px">@endif
                        </label><br>
                    @endforeach

                @elseif($q->type === 'multiple')
                    @foreach($q->options as $opt)
                        <label><input type="checkbox" name="answers[{{ $q->id }}][]" value="{{ $opt->id }}">
                            {{ $opt->text }}
                            @if($opt->image)<img src="{{ asset('storage/'.$opt->image) }}" style="max-height:60px">@endif
                        </label><br>
                    @endforeach

                @elseif($q->type === 'number')
                    <input type="number" name="answers[{{ $q->id }}]" step="any" style="width:200px">

                @elseif($q->type === 'text')
                    <input type="text" name="answers[{{ $q->id }}]" style="width:100%">
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-green">Submit Quiz</button>
    </form>
@endsection
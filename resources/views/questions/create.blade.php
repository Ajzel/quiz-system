@extends('layouts.app')
@section('content')
    <h3>Add Question to: {{ $quiz->title }}</h3>
    <form method="POST" action="{{ route('questions.store', $quiz) }}" enctype="multipart/form-data">
        @csrf
        <label>Question Type</label>
        <select name="type" id="qtype" onchange="toggleOptions()">
            <option value="binary">Binary (Yes/No)</option>
            <option value="single">Single Choice</option>
            <option value="multiple">Multiple Choice</option>
            <option value="number">Number Input</option>
            <option value="text">Text Input</option>
        </select>

        <label>Question Body (HTML allowed)</label>
        <textarea name="body" rows="3" required></textarea>

        <label>Question Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <label>Video URL (optional)</label>
        <input type="text" name="video_url" placeholder="https://youtube.com/...">

        <label>Marks</label>
        <input type="number" name="marks" value="1" min="1">

        <div id="options-section">
            <h4>Options <button type="button" onclick="addOption()" class="btn" style="font-size:0.8em">+ Add Option</button></h4>
            <p style="color:#6b7280;font-size:0.85em">Check the box next to correct answer(s).</p>
            <div id="options-list"></div>
        </div>

        <br>
        <button type="submit" class="btn">Save Question</button>
    </form>

    <script>
        let count = 0;
        function addOption() {
            const div = document.createElement('div');
            div.style = 'border:1px solid #e5e7eb;padding:10px;margin-bottom:8px;border-radius:4px';
            div.innerHTML = `
                <input type="text" name="option_text[]" placeholder="Option text" style="width:60%;display:inline-block">
                <input type="file" name="option_image[]" accept="image/*" style="width:25%;display:inline-block">
                <label><input type="checkbox" name="is_correct[]" value="${count}"> Correct</label>
            `;
            document.getElementById('options-list').appendChild(div);
            count++;
        }
        function toggleOptions() {
            const type = document.getElementById('qtype').value;
            const show = ['binary','single','multiple','number','text'];
            document.getElementById('options-section').style.display = show.includes(type) ? 'block' : 'none';
        }
        // Add 2 default options
        addOption(); addOption();
    </script>
@endsection
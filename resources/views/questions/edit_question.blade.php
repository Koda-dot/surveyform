
@extends('layouts.app')

@section('content')
<div class="container p-4">
    <h1>Edit Question</h1>
    <form action="{{ route('questions.update', [$survey, $question]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="question_text" class="form-label">Question Text</label>
            <input type="text" class="form-control" id="question_text" name="question_text" value="{{ $question->question_text }}">
        </div>
        <div class="mb-3">
            <label for="question_type" class="form-label">Question Type</label>
            <select class="form-control" id="question_type" name="question_type">
                <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="radio" {{ $question->question_type == 'radio' ? 'selected' : '' }}>Radio</option>
                <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Question</button>
        <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

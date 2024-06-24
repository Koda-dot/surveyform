@extends('layouts.app')

@section('content')
<div class="container p-4">
    <h1>Edit Survey</h1>
    <form action="{{ route('surveys.update', $survey) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $survey->title }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $survey->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Survey</button>
        <a href="{{ route('surveys.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <h2 class="mt-4">Questions</h2>
    @foreach ($survey->questions as $question)
        <div class="mb-4">
            <h4>{{ $question->question_text }}</h4>
            <a href="{{ route('questions.edit', [$survey, $question]) }}" class="btn btn-secondary btn-sm">Edit Question</a>
        </div>
    @endforeach
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->title }}</h1>
    <form action="{{ route('surveys.responses.store', $survey) }}" method="POST">
        @csrf
        @foreach ($survey->questions as $question)
            <div class="mb-4">
                <h4>{{ $question->question_text }}</h4>
                @if ($question->question_type == 'text')
                    <input type="text" name="responses[{{ $question->id }}][text]" class="form-control">
                @elseif ($question->question_type == 'radio')
                    @foreach ($question->choices as $choice)
                        <div class="form-check">
                            <input type="radio" name="responses[{{ $question->id }}][choices]" value="{{ $choice->id }}" class="form-check-input">
                            <label class="form-check-label">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @elseif ($question->question_type == 'checkbox')
                    @foreach ($question->choices as $choice)
                        <div class="form-check">
                            <input type="checkbox" name="responses[{{ $question->id }}][choices][]" value="{{ $choice->id }}" class="form-check-input">
                            <label class="form-check-label">{{ $choice->choice_text }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Responses</button>
    </form>
</div>
@endsection



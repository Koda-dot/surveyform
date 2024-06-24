

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Responses for {{ $survey->title }}</h1>
    @foreach ($survey->questions as $question)
        <div class="mb-4">
            <h4>{{ $question->question_text }}</h4>
            @foreach ($question->responses as $response)
                <div class="border p-2 mb-2">
                    @if ($question->question_type == 'text')
                        <p>{{ $response->response_text }}</p>
                    @else
                        @foreach ($response->choices as $choice)
                            <p>{{ $choice->choice_text }}</p>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
    <a href="{{ route('surveys.index') }}" class="btn btn-primary">Back to Surveys</a>
</div>
@endsection
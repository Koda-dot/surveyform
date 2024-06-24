
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Surveys</h1>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <a href="{{ route('surveys.create') }}" class="btn btn-primary mb-3">Create New Survey</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td>{{ $survey->title }}</td>
                    <td>{{ $survey->description }}</td>
                    <td>
                        <a href="{{ route('surveys.show', $survey) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('surveys.responses', $survey) }}" class="btn btn-success btn-sm">View Responses</a>
                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this survey?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

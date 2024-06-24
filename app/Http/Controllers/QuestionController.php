<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function edit(Survey $survey, Question $question)
    {
        return view('questions.edit_question', compact('survey', 'question'));
    }

    public function update(Request $request, Survey $survey, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|string|in:text,radio,checkbox',
        ]);

        $question->update($request->only('question_text', 'question_type'));

        return redirect()->route('surveys.edit', $survey)->with('status', 'Question updated successfully.');
    }
}


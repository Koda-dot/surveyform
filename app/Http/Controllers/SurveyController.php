<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseChoice;
use App\Models\Answer;
use App\Models\Choice;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('status', 'Survey deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.question_type' => 'required|string|in:text,radio,checkbox',
            'questions.*.choices.*.choice_text' => 'nullable|string|max:255',
        ]);

        $survey = Survey::create($request->only('title', 'description'));

        foreach ($request->questions as $questionData) {
            $question = new Question([
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
            ]);

            $survey->questions()->save($question);

            if (isset($questionData['choices'])) {
                foreach ($questionData['choices'] as $choiceData) {
                    if (!empty($choiceData['choice_text'])) {
                        $choice = new Choice(['choice_text' => $choiceData['choice_text']]);
                        $question->choices()->save($choice);
                    }
                }
            }
        }

        return redirect()->route('surveys.index')->with('status', 'Survey created successfully!');
    }
    
    public function storeResponses(Request $request, Survey $survey)
    {
        foreach ($request->responses as $question_id => $responseData) {
            $response = Response::create([
                'survey_id' => $survey->id,
                'question_id' => $question_id,
                'user_id' => auth()->id(), // assuming responses are associated with authenticated users
                'response_text' => $responseData['text'] ?? null,
            ]);

            if (isset($responseData['choices'])) {
                if (is_array($responseData['choices'])) {
                    foreach ($responseData['choices'] as $choice_id) {
                        ResponseChoice::create([
                            'response_id' => $response->id,
                            'choice_id' => $choice_id,
                        ]);
                    }
                } else {
                    ResponseChoice::create([
                        'response_id' => $response->id,
                        'choice_id' => $responseData['choices'],
                    ]);
                }
            }
        }

        return redirect()->route('surveys.show', $survey)->with('status', 'Responses saved successfully.');
    }

    public function edit(Survey $survey)
    {
        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $survey->update($request->only('title', 'description'));

    return redirect()->route('surveys.index')->with('status', 'Survey updated successfully.');
}


    public function show(Survey $survey)
    {
        $survey->load('questions.choices');
        return view('surveys.show', compact('survey'));
    }

    public function responses(Survey $survey)
    {
        $survey->load('questions.responses.choices');
        return view('surveys.responses', compact('survey'));
    }

    public function submitResponse(Request $request, Survey $survey)
    {
        $response = $survey->responses()->create();

        foreach ($survey->questions as $question) {
            $response->answers()->create([
                'question_id' => $question->id,
                'answer_text' => $request->input('question_'.$question->id),
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Survey response submitted successfully.');
    }
}

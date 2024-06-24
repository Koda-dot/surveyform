
@extends('layouts.app')

@section('content')
<div class="container p-4">
    <h1>Create New Survey</h1>
    <form action="{{ route('surveys.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div id="questions-container" class="mb-3">
            <h2>Questions</h2>
            <!-- Questions will be dynamically added here -->
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <button type="button" class="btn btn-primary" id="add-question-btn">Add Question</button>
            <button type="submit" class="btn btn-success">Create Survey</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let questionCount = 0;

        document.getElementById('add-question-btn').addEventListener('click', function() {
            questionCount++;
            const questionContainer = document.createElement('div');
            questionContainer.className = 'question mb-3';
            questionContainer.innerHTML = `
                <div class="mb-3">
                    <label for="questions[${questionCount}][question_text]" class="form-label">Question Text</label>
                    <input type="text" class="form-control" id="questions[${questionCount}][question_text]" name="questions[${questionCount}][question_text]" required>
                </div>
                <div class="mb-3">
                    <label for="questions[${questionCount}][question_type]" class="form-label">Question Type</label>
                    <select class="form-control question-type-select" id="questions[${questionCount}][question_type]" name="questions[${questionCount}][question_type]" data-question-id="${questionCount}" required>
                        <option value="text">Text</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>
                <div class="choices-container" id="choices-container-${questionCount}">
                    <!-- Choices will be dynamically added here for radio/checkbox questions -->
                </div>
                <button type="button" class="btn btn-danger remove-question-btn">Remove Question</button>
                <hr>
            `;
            document.getElementById('questions-container').appendChild(questionContainer);

            // Attach event listener to the new remove button
            questionContainer.querySelector('.remove-question-btn').addEventListener('click', function() {
                questionContainer.remove();
            });

            // Attach event listener to the question type select
            questionContainer.querySelector('.question-type-select').addEventListener('change', function(event) {
                const questionId = event.target.dataset.questionId;
                const questionType = event.target.value;
                const choicesContainer = document.getElementById(`choices-container-${questionId}`);

                // Clear any existing choices
                choicesContainer.innerHTML = '';

                if (questionType === 'radio' || questionType === 'checkbox') {
                    const addChoiceButton = document.createElement('button');
                    addChoiceButton.type = 'button';
                    addChoiceButton.className = 'btn btn-secondary add-choice-btn mb-2';
                    addChoiceButton.innerText = 'Add Choice';
                    addChoiceButton.dataset.questionId = questionId;

                    // Add choices container and add choice button
                    choicesContainer.appendChild(addChoiceButton);

                    // Add event listener for add choice button
                    addChoiceButton.addEventListener('click', function() {
                        const choiceCount = choicesContainer.querySelectorAll('.choice').length;
                        const choiceContainer = document.createElement('div');
                        choiceContainer.className = 'choice mb-2';
                        choiceContainer.innerHTML = `
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="questions[${questionId}][choices][${choiceCount}][choice_text]" placeholder="Choice Text" required>
                                <button type="button" class="btn btn-danger remove-choice-btn">Remove</button>
                            </div>
                        `;
                        choicesContainer.insertBefore(choiceContainer, addChoiceButton);

                        // Attach event listener to remove choice button
                        choiceContainer.querySelector('.remove-choice-btn').addEventListener('click', function() {
                            choiceContainer.remove();
                        });
                    });
                }
            });
        });
    });
</script>
@endsection

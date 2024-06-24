<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{survey}/responses', [SurveyController::class, 'submitResponse'])->name('surveys.submitResponse');
    Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{survey}/responses', [SurveyController::class, 'storeResponses'])->name('surveys.responses.store');
    
    Route::resource('surveys', SurveyController::class);
    Route::get('/surveys/{survey}/responses', [SurveyController::class, 'responses'])->name('surveys.responses');

    Route::get('surveys/{survey}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('surveys/{survey}', [SurveyController::class, 'update'])->name('surveys.update');

    Route::get('surveys/{survey}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('surveys/{survey}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');

});

require __DIR__.'/auth.php';

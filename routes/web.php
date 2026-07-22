<?php

use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StepController;



Route::redirect('/', '/ideas');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');

    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');

    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');

    Route::get("/ideas/{idea}", [IdeaController::class, 'show'])->name('idea.show');

    Route::patch("/steps/{step}", [StepController::class, 'update'])->name('step.update');

    Route::delete("/ideas/{idea}", [IdeaController::class, 'destroy'])->name('idea.destroy');
});

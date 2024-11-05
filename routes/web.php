<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Workout\WorkoutTypes;
use App\Livewire\Workout\WorkoutTypesCreate;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Livewire Full Component Page
    Route::get('/wk_types', WorkoutTypes::class)->name('wk_types.index');
    Route::get('/wk_types/create', WorkoutTypesCreate::class)->name('wk_types.create');


});

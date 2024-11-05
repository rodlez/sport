<?php

use App\Http\Controllers\Workout\WorkoutTypeController;
use Illuminate\Support\Facades\Route;

// Livewire Full Component Pages
use App\Livewire\Workout\WorkoutTypes;
use App\Livewire\Workout\WorkoutTypesCreate;
use App\Livewire\Workout\WorkoutTypesEdit;
use App\Livewire\Workout\WorkoutTypesShow;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /* WORKOUT TYPES */
    Route::get('/wk_types', WorkoutTypes::class)->name('wk_types.index');       
    Route::get('/wk_types/{type}', WorkoutTypesShow::class)->name('wk_types.show');
    Route::put('/wk_types/{type}', [WorkoutTypeController::class, 'update'])->name('wk_types.update');
    Route::delete('/wk_types/{type}', [WorkoutTypeController::class, 'destroy'])->name('wk_types.destroy');    
    Route::get('/wk_types/create', WorkoutTypesCreate::class)->name('wk_types.create');
    Route::get('/wk_types/edit/{type}', WorkoutTypesEdit::class)->name('wk_types.edit');


});

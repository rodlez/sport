<?php

use Illuminate\Support\Facades\Route;

// Controllers

use App\Http\Controllers\Sport\SportCategoryController;
use App\Http\Controllers\Sport\SportTagController;
use App\Http\Controllers\Workout\WorkoutController;
use App\Http\Controllers\Workout\WorkoutFileController;
use App\Http\Controllers\Workout\WorkoutLevelController;
use App\Http\Controllers\Workout\WorkoutTypeController;

// Livewire Full Component Pages

// SP Categories
use App\Livewire\Sport\SportCategories;
use App\Livewire\Sport\SportCategoriesCreate;
use App\Livewire\Sport\SportCategoriesEdit;
use App\Livewire\Sport\SportCategoriesShow;
use App\Livewire\Sport\SportCreate;
use App\Livewire\Sport\SportMain;
// SP Tags
use App\Livewire\Sport\SportTags;
use App\Livewire\Sport\SportTagsCreate;
use App\Livewire\Sport\SportTagsEdit;
use App\Livewire\Sport\SportTagsShow;
// Workouts
use App\Livewire\Workout\WorkoutMain;
use App\Livewire\Workout\WorkoutCreate;
use App\Livewire\Workout\WorkoutShow;
use App\Livewire\Workout\WorkoutEdit;
use App\Livewire\Workout\WorkoutFileUpload;
// WK Levels
use App\Livewire\Workout\WorkoutLevels;
use App\Livewire\Workout\WorkoutLevelsCreate;
use App\Livewire\Workout\WorkoutLevelsEdit;
use App\Livewire\Workout\WorkoutLevelsShow;
//WK Types
use App\Livewire\Workout\WorkoutTypes;
use App\Livewire\Workout\WorkoutTypesCreate;
use App\Livewire\Workout\WorkoutTypesEdit;
use App\Livewire\Workout\WorkoutTypesShow;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /* WORKOUTS */
    Route::get('/workouts', WorkoutMain::class)->name('workouts.index');
    Route::get('/workouts/create', WorkoutCreate::class)->name('workouts.create');
    Route::get('/workouts/{workout}', WorkoutShow::class)->name('workouts.show');
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
    Route::get('/workouts/edit/{workout}', WorkoutEdit::class)->name('workouts.edit');

    /* WORKOUT FILES */
    Route::get('/workouts/{workout}/file', WorkoutFileUpload::class)->name('workouts.upload');
    Route::get('/workouts/{workout}/file/{file}', [WorkoutFileController::class, 'download'])->name('workoutsfile.download');
    Route::delete('/workouts/{workout}/file/{file}', [WorkoutFileController::class, 'destroy'])->name('workoutsfile.destroy');

    /* WORKOUT TYPES */
    Route::get('/wk_types', WorkoutTypes::class)->name('wk_types.index');
    Route::get('/wk_types/create', WorkoutTypesCreate::class)->name('wk_types.create');
    Route::get('/wk_types/{type}', WorkoutTypesShow::class)->name('wk_types.show');
    Route::put('/wk_types/{type}', [WorkoutTypeController::class, 'update'])->name('wk_types.update');
    Route::delete('/wk_types/{type}', [WorkoutTypeController::class, 'destroy'])->name('wk_types.destroy');
    Route::get('/wk_types/edit/{type}', WorkoutTypesEdit::class)->name('wk_types.edit');

    /* WORKOUT LEVELS */
    Route::get('/wk_levels', WorkoutLevels::class)->name('wk_levels.index');
    Route::get('/wk_levels/create', WorkoutLevelsCreate::class)->name('wk_levels.create');
    Route::get('/wk_levels/{level}', WorkoutLevelsShow::class)->name('wk_levels.show');
    Route::put('/wk_levels/{level}', [WorkoutLevelController::class, 'update'])->name('wk_levels.update');
    Route::delete('/wk_levels/{level}', [WorkoutLevelController::class, 'destroy'])->name('wk_levels.destroy');
    Route::get('/wk_levels/edit/{level}', WorkoutLevelsEdit::class)->name('wk_levels.edit');

    /* SPORTS */
    Route::get('/sports', SportMain::class)->name('sports.index');
    Route::get('/sports/create', SportCreate::class)->name('sports.create');


    /* SPORT CATEGORIES */
    Route::get('/sp_categories', SportCategories::class)->name('sp_categories.index');
    Route::get('/sp_categories/create', SportCategoriesCreate::class)->name('sp_categories.create');
    Route::get('/sp_categories/{category}', SportCategoriesShow::class)->name('sp_categories.show');
    Route::put('/sp_categories/{category}', [SportCategoryController::class, 'update'])->name('sp_categories.update');
    Route::delete('/sp_categories/{category}', [SportCategoryController::class, 'destroy'])->name('sp_categories.destroy');
    Route::get('/sp_categories/edit/{category}', SportCategoriesEdit::class)->name('sp_categories.edit');

    /* SPORT TAGS */
    Route::get('/sp_tags', SportTags::class)->name('sp_tags.index');
    Route::get('/sp_tags/create', SportTagsCreate::class)->name('sp_tags.create');
    Route::get('/sp_tags/{tag}', SportTagsShow::class)->name('sp_tags.show');
    Route::put('/sp_tags/{tag}', [SportTagController::class, 'update'])->name('sp_tags.update');
    Route::delete('/sp_tags/{tag}', [SportTagController::class, 'destroy'])->name('sp_tags.destroy');
    Route::get('/sp_tags/edit/{tag}', SportTagsEdit::class)->name('sp_tags.edit');
});

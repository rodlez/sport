<?php

namespace App\Livewire\Workout;

use Livewire\Component;
use App\Models\Workout\Workout;
use App\Services\WorkoutService;

class WorkoutShow extends Component
{
    public Workout $workout;

    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        WorkoutService $workoutService,
    ) {
        $this->workoutService = $workoutService;
    }

    public function mount(Workout $workout)
    {
        $this->workout = $workout;
    }
    
    public function render()
    {

        $videos = $this->workoutService->getVideosito($this->workout);
        //$videos = Workout::files->get();
        //dd($videos);

        return view('livewire.workout.workout-show', [
            'workout'   => $this->workout,
            'videos'    => $videos, 
        ])->layout('layouts.app');
    }
}

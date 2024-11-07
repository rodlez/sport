<?php

namespace App\Livewire\Workout;

use App\Services\WorkoutService;
use Livewire\Component;

class WorkoutCreate extends Component
{

    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        WorkoutService $workoutService,
    ) {
        $this->workoutService = $workoutService;
    }

    public function render()
    {

        return view('livewire.workout.workout-create', [
            'types' => $this->workoutService->getTypes()
        ])->layout('layouts.app');
    }
}

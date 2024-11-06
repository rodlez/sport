<?php

namespace App\Livewire\Workout;

use Livewire\Component;
use App\Models\Workout\Workout;

class WorkoutShow extends Component
{
    public Workout $workout;

    public function mount(Workout $workout)
    {
        $this->workout = $workout;
    }
    
    public function render()
    {
        return view('livewire.workout.workout-show', [
            'workout' => $this->workout
        ])->layout('layouts.app');
    }
}

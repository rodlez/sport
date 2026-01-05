<?php

namespace App\Livewire\Workout;

use App\Models\Workout\WorkoutLevel;
use Livewire\Component;

class WorkoutLevelsEdit extends Component
{
    public WorkoutLevel $level;

    public function mount(WorkoutLevel $level)
    {
        $this->level = $level;
    }

    public function render()
    {
        return view('livewire.workout.workout-levels-edit', [
            'level' => $this->level
        ])->layout('layouts.app');
    }

  
}

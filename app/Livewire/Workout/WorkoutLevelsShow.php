<?php

namespace App\Livewire\Workout;

use App\Models\Workout\WorkoutLevel;
use Livewire\Component;

class WorkoutLevelsShow extends Component
{
    public WorkoutLevel $level;

    public function mount(WorkoutLevel $level)
    {
        $this->level = $level;
    }
    
    public function render()
    {
        return view('livewire.workout.workout-levels-show', [
            'level' => $this->level
        ])->layout('layouts.app');
    }    
   
}

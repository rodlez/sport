<?php

namespace App\Livewire\Workout;

use Livewire\Component;
use App\Models\Workout\WorkoutType;

class WorkoutTypesEdit extends Component
{
    public WorkoutType $type;

    public function mount(WorkoutType $type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.workout.workout-types-edit', [
            'type' => $this->type
        ])->layout('layouts.app');
    }
}

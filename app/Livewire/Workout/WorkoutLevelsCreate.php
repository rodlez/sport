<?php

namespace App\Livewire\Workout;

use App\Models\Workout\WorkoutLevel;
use Illuminate\Database\QueryException;
use Livewire\Component;

class WorkoutLevelsCreate extends Component
{
    public $inputs;
    public $show = 0;

    protected $rules = [
        'inputs.*.name' => 'required|min:3|unique:workout_levels,name|distinct'
    ];

    protected $messages = [
        'inputs.*.name.required' => 'The field is required',
        'inputs.*.name.min' => 'The field must have at least 3 characters',
        'inputs.*.name.unique' => 'The level with this name is already created',
        'inputs.*.name.distinct' => 'This field has a duplicate, name must be unique'
    ];

    public function mount()
    {
        $this->fill([
            'inputs' => collect([['name' => '']])
        ]);
    }

    public function help()
    {
        $this->show++;
    }

    public function remove($key)
    {
        $this->inputs->pull($key);
    }

    public function add()
    {
        $this->inputs->push(['name' => '']);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->inputs as $input) {

            try {
                WorkoutLevel::create(['name' => $input['name']]);
            } catch (QueryException $exception) {

                $errorInfo = $exception->errorInfo;
                // Return the response to the client..
                return to_route('wk_levels.index')->with('message', 'Error(' . $errorInfo[0] . ') creating the level (' . $input['name'] . ')');
            }
        }

        $message = "";
        $this->inputs->count() === 1 ? $message = 'Level ' . $input['name'] . ' created' : $message = $this->inputs->count() . ' new levels created';

        return to_route('wk_levels.index')->with('message', $message);
    }

    public function render()
    {
        return view('livewire.workout.workout-levels-create')->layout('layouts.app');
    }
   
}

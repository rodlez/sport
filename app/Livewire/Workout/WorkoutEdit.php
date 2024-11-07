<?php

namespace App\Livewire\Workout;

use App\Livewire\Texteditor\Quill;
use Livewire\Component;
use App\Models\Workout\Workout;
use App\Services\WorkoutService;
use Illuminate\Http\Request;

class WorkoutEdit extends Component
{
    public $title;
    public $author;
    public $duration;
    public $type_id;
    public $url;
    public $description;

    // TODO: custom validation for duration range of values (0 - 200)
    protected $rules = [
        'title'         => 'required|min:3',
        'author'        => 'required|min:3',
        'duration'      => 'required|numeric',
        'type_id'       => 'required',
        'url'           => 'nullable|url',
        // Because Quill Editor include at least <p></p>, always have at least 7 extra characters
        'description'   => 'nullable|min:10',       
        
    ];

    protected $messages = [
        'type_id.required' => 'Select one type of workout.',
        'description.min' => 'The description must have at least 3 characters.'
    ];

    /* Quill Editor - removing spaces  */
 
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];

    public function quill_value_updated($value){

       // Remove more than 2 consecutive whitespaces
       if ( preg_match( '/(\s){2,}/s', $value ) === 1 ) {
           $value = preg_replace( '/(\s){2,}/s', '', $value );           
       }
       
       // Because Quill Editor includes <p><br></p> in case you type and then leave the input blank
       if($value == "<p><br></p>" || $value == "<h1><br></h1>" || $value == "<h2><br></h2>" || $value == "<h3><br></h3>" || $value == "<p></p>" || $value == "<p> </p>") { 
           $value = null;
       }
       
       $this->description = $value;

    }
    
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

        $this->title        = $this->workout->title;
        $this->author       = $this->workout->author;
        $this->duration     = $this->workout->duration;
        $this->type_id      = $this->workout->type_id;        
        $this->url          = $this->workout->url;
        $this->description  = $this->workout->description;

    }

    public function save(Request $request)
    {

        $validated = $this->validate();
        // include the user that created the Workout
        $validated['user_id'] = $request->user()->id;        

        $this->workout->update($validated);
        
        return to_route('workouts.index', $this->workout)->with('message', 'Workout (' . $this->workout->title . ') successfully updated.');
    }

    public function render()
    {
        return view('livewire.workout.workout-edit', [
            'workout' => $this->workout,
            'types' => $this->workoutService->getTypes()
        ])->layout('layouts.app');
    }
}

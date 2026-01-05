<?php

namespace App\Livewire\Workout;

use App\Livewire\Texteditor\Quill;
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutLevel;
use App\Models\Workout\WorkoutType;
use App\Services\WorkoutService;
use Illuminate\Http\Request;
use Livewire\Component;

class WorkoutCreate extends Component
{

    public $title;
    public $author;
    public $duration;
    public $type_id;
    public $level_id;
    public $url;
    public $description;

    // TODO: custom validation for duration range of values (0 - 200)
    protected $rules = [
        'title'         => 'required|min:3',
        'author'        => 'required|min:3',
        'duration'      => 'required|numeric',
        'type_id'       => 'required',
        'level_id'      => 'required',
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
    
    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        WorkoutService $workoutService,
    ) {
        $this->workoutService = $workoutService;
    }

    // Hook Runs once, immediately after the component is instantiated, but before render() is called. This is only called once on initial page load and never called again, even on component refreshes
    public function mount()
    {
        // If not selected, get the ID value of the first element show in the select element
        $this->type_id = WorkoutType::orderBy('name', 'asc')->pluck('id')->first();
        $this->level_id = WorkoutLevel::orderBy('id', 'asc')->pluck('id')->first();
    }

    public function save(Request $request)
    {

        $validated = $this->validate();
        // include the user that created the Workout
        $validated['user_id'] = $request->user()->id;    

        $workout = Workout::create($validated);
        
        return to_route('workouts.index', $workout)->with('message', 'Workout (' . $workout->title . ') successfully created.');
    }

    public function render()
    {

        return view('livewire.workout.workout-create', [
            'types' => $this->workoutService->getTypes(),
            'levels' => $this->workoutService->getLevels()
        ])->layout('layouts.app');
    }
}

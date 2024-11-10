<?php

namespace App\Livewire\Sport;

use App\Livewire\Texteditor\Quill;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
use App\Services\SportService;
use Illuminate\Http\Request;
use Livewire\Component;

class SportCreate extends Component
{
    
    public $status;
    public $title;
    public $date;
    public $location;
    public $duration;
    public $distance;
    //public $url;
    public $info;
    public $category_id;
    public $selectedTags = [];

    public $selectedWorkouts = [];

    public $inputs;
    
    protected $rules = [
        'title'             => 'required|min:3',
        'status'            => 'nullable',
        'category_id'       => 'required',
        'selectedTags'      => 'required',
        'selectedWorkouts'  => 'nullable',
        'date'              => 'required|after:01/01/2024',
        'location'          => 'required|min:2',
        'duration'          => 'required|gte:5',
        'distance'          => 'nullable|gte:0',
        //'url'             => 'nullable|url',
        'info'              => 'nullable|min:3',
        'inputs.*.url'      => 'nullable|min:3'
    ];

    protected $messages = [
        'category_id.required' => 'Select one category.',
        'selectedTags.required' => 'At least 1 tag must be selected.',
        'inputs.*.url.min' => 'The field url must have at least 3 characters',
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
       
       $this->info = $value;

    }
    
    protected SportService $sportService;

    public function boot(
        SportService $sportService,
    ) {
        $this->sportService = $sportService;
    }

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->status = false;
        $this->distance = 0;
        $this->category_id = SportCategory::orderBy('name', 'asc')->pluck('id')->first();

        $this->fill([
            'inputs' => collect([['url' => '']])
        ]);
    }

    public function remove($key)
    {
        $this->inputs->pull($key);
    }

    public function add()
    {
        $this->inputs->push(['url' => '']);
    }


    public function save(Request $request)
    //public function save()
    {

        $validated = $this->validate();
        $validated['distance'] != "" ?: $validated['distance'] = 0;
        $validated['user_id'] = $request->user()->id;

        // TODO: JSONENCODE DECODE URL ARRAYS

        $urlList = [];
        foreach ($this->inputs as $input) {
            $urlList[] = $input['url'];
        }
        // filter the empty possible url arrays and reorder the indexes        
        $urlListFiltered = array_values(array_filter($urlList));

        $validated['url'] = json_encode($urlListFiltered);  
        
        //dd($validated);

        $sport = $this->sportService->insertSport($validated);

        return to_route('sports.index', $sport)->with('message', 'Sport (' . $sport->title . ') created.');
    }
    
    public function render()
    {
        // Using Service
        //$categories = $this->sportService->getCategories();
        //$tags       = $this->sportService->getTags();
        //$workouts   = $this->sportService->getWorkouts();

        // Using Eloquent Collection Methods
        $categories = SportCategory::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags       = SportTag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        $workouts   = Workout::all()->sortBy('title', SORT_NATURAL|SORT_FLAG_CASE);

        return view('livewire.sport.sport-create', [
            'categories'        => $categories,
            'tags'              => $tags,
            'workouts'          => $workouts
        ])->layout('layouts.app');
    }
}

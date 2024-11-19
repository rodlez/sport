<?php

namespace App\Livewire\Sport;

use App\Livewire\Texteditor\Quill;
use App\Models\Sport\Sport;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
use App\Services\SportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SportEdit extends Component
{
    public $status;
    public $title;
    public $date;
    public $location;
    public $duration;
    public $distance;
    public $urlJson;
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

    public Sport $sport;
    
    protected SportService $sportService;

    public function boot(
        SportService $sportService,
    ) {
        $this->sportService = $sportService;
    }

    public function mount(Sport $sport)
    {
        $this->sport = $sport;

        $this->title = $this->sport->title;
        $this->status = $this->sport->status;
        $this->date = $this->sport->date;
        $this->category_id = $this->sport->category_id;
        $this->location = $this->sport->location;
        $this->duration = $this->sport->duration;
        $this->distance = $this->sport->distance;
        $this->urlJson = $this->sport->url;
        $this->info = $this->sport->info;
        
        $this->selectedTags = $this->sportService->getSportEntryTags($this->sport);

        $this->selectedWorkouts = $this->sportService->getSportEntryWorkouts($this->sport);

        // Decode the URL Json to split in different strings for each URL
        $urlsDecoded = [];
        foreach (json_decode($this->urlJson) as $value) {
            $urlsDecoded[] = ['url' => $value];
        }

        $this->fill([
            'inputs' => collect($urlsDecoded)
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

        // Enecode the different URLs in a Json Object to store in the DB
        $urlList = [];
        foreach ($this->inputs as $input) {
            $urlList[] = $input['url'];
        }
        // filter the empty possible url arrays and reorder the indexes        
        $urlListFiltered = array_values(array_filter($urlList));

        $validated['url'] = json_encode($urlListFiltered);  
        
        //dd($validated);

        $sport = $this->sportService->updateSport($this->sport, $validated);

        return to_route('sports.show', $sport)->with('message', 'Sport (' . $sport->title . ') successfully edited.');
    }
    
    public function render()
    {
        // resticted access - only user who owns the Sport has access
        if ($this->sport->user_id !== Auth::id()) {
            abort(403);
        }   

        // Using Eloquent Collection Methods
        $categories = SportCategory::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);    
        $tags       = SportTag::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);
        $workouts   = Workout::all()->sortBy('title', SORT_NATURAL|SORT_FLAG_CASE);

        return view('livewire.sport.sport-edit', [
            'categories'        => $categories,
            'tags'              => $tags,
            'workouts'          => $workouts
        ])->layout('layouts.app');
    }
    
    
}

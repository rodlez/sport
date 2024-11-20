<?php

namespace App\Livewire\Workout;

use App\Models\Workout\Workout;
use App\Services\WorkoutService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class WorkoutMain extends Component
{
    use WithPagination;

    // order and pagination
    #[Url(as: 'o', except: '')]
    public $orderColumn = "id";
    #[Url(as: 'so', except: '')]
    public $sortOrder = "desc";
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $perPage = 25;

    // search
    #[Url(as: 'se', except: '')]
    public $search = "";

    // filters    
    public $showFilters = 0;

    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;

    #[Url(as: 'ty', except: '')]
    public $tipo = 0;

    #[Url(as: 'lev', except: '')]
    public $nivel = 0;

    public $durationFrom;
    public $initialDurationFrom;
    public $durationTo;
    public $initialDurationTo;

    // multiple batch selections
    public $selections = [];   

    // select all
    public $selectAll = false;

    public function updated()
    {        
        $this->resetPage();
    }

    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        WorkoutService $workoutService,
    ) {
        $this->workoutService = $workoutService;
    }

    public function mount() {
        $this->dateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(Workout::max('created_at')));
        $this->initialDateTo = date('Y-m-d', strtotime(Workout::max('created_at')));

        $this->durationFrom = Workout::min('duration');
        $this->initialDurationFrom = Workout::min('duration');
        $this->durationTo = Workout::max('duration');
        $this->initialDurationTo = Workout::max('duration');
    } 

    // prefix updated method to access the value of the variable wired
    public function updatedSelectAll($value)
    {        
        if ($value) {
            $this->selections = Workout::pluck('id')->toArray();
        } else {
            $this->selections = [];
        }
    }  

    public function activateFilter()
    {
        $this->showFilters++;
    }

    public function clearFilters()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(Workout::max('created_at')));
        $this->tipo = 0;
        $this->nivel = 0;
        $this->durationFrom = Workout::min('duration');
        $this->durationTo = Workout::max('duration');
    }

    public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(Workout::max('created_at')));
    }

    public function clearFilterDuration()
    {
        $this->durationFrom = Workout::min('duration');
        $this->durationTo = Workout::max('duration');
    }

    public function clearFilterTipo()
    {
        $this->tipo = 0;
    }

    public function clearFilterNivel()
    {
        $this->nivel = 0;
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function bulkClear()
    {
        $this->selections = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        
        $result = $this->workoutService->bulkDeleteWorkouts($this->selections);

        return to_route('workouts.index')->with('message', $result);
    }

    public function resetAll()
    {
        $this->clearFilters();
        $this->clearSearch();
        //$this->bulkClear();
    }

    public function sorting($columnName = "")
    {
        $caretOrder = 'up';
        if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
            $caretOrder = 'down';
        } else {
            $this->sortOrder = 'asc';
            $caretOrder = 'up';
        }

        $this->sortLink = '<i class="fa-solid fa-caret-' . $caretOrder . '"></i>';
        $this->orderColumn = $columnName;
    }


    public function render()
    {

        $found = 0;

        // get only the types that have at least one entry
        $types = Workout::select(
            'workout_types.id as id',
            'workout_types.name as name'
        )
            ->join('workout_types', 'workouts.type_id', '=', 'workout_types.id')->distinct('type_id')->orderBy('name', 'asc')->get()->toArray();

        // get only the levels that have at least one entry
        $levels = Workout::select(
            'workout_levels.id as id',
            'workout_levels.name as name'
        )
            ->join('workout_levels', 'workouts.level_id', '=', 'workout_levels.id')->distinct('level_id')->orderBy('id', 'asc')->get()->toArray();

        // Main Selection, Join tables code_entries, code_categories and code_entry_tag
        $entries = Workout::select(
            'workouts.id as id',
            'workout_types.name as type_name', 
            'workout_levels.name as level_name',           
            'workouts.title as title',
            'workouts.author as author',
            'workouts.duration as duration',
            'workouts.url as url',
            'workouts.description as description',
            'workouts.created_at as created',
        )
            ->join('workout_types', 'workouts.type_id', '=', 'workout_types.id')
            ->join('workout_levels', 'workouts.level_id', '=', 'workout_levels.id')
            ->distinct('workouts.id')
            ->orderby($this->orderColumn, $this->sortOrder);

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $entries = $entries->whereDate('workouts.created_at', '>=', $this->dateFrom)
                ->whereDate('workouts.created_at', '<=', $this->dateTo);
            }
            else {
                 // TODO: Show error
                //dd('errorcito');
            }
        }  

        // tipo filter
        if ($this->tipo != 0) {
            $entries = $entries->where('workout_types.name', '=', $this->tipo);
        }

        // level filter
        if ($this->nivel != 0) {
            $entries = $entries->where('workout_levels.name', '=', $this->nivel);
        }

        // interval duration filter
        if ($this->durationFrom <= $this->durationTo) {
            $entries = $entries->whereBetween('workouts.duration', [$this->durationFrom, $this->durationTo]);
        } else {
            // TODO: Show error            
            //dd('error');
        }

        // Search
        if (!empty($this->search)) {
            // trim search in case copy paste or start the search with whitespaces
            // search by id or name
            //$entries->orWhere('id', "like", "%" . $this->search . "%");
            //->orWhere('location', "like", "%" . $this->search . "%")
            $entries = $entries->where('title', "like", "%" . trim($this->search) . "%");
            $found = $entries->count();
        }

        // total values for display stats
        // clone to make a copy and not have the same values as entries
        $stats = clone $entries;
        $totalEntries = $stats->count();
        $differentTypes = $stats->distinct('workout_types.id')->count();
        $differentLevels = $stats->distinct('workout_levels.id')->count();
        $totalDuration = $stats->get()->sum('duration');


        $entries = $entries->paginate($this->perPage);

        return view('livewire.workout.workout-main', [
            'entries' => $entries,
            'found' => $found,
            'total' => $totalEntries,
            'differentTypes' => $differentTypes,
            'differentLevels' => $differentLevels,
            'column' => $this->orderColumn,
            'types' => $types,
            'levels' => $levels,
            'totalDuration' => $totalDuration,
        ])->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Workout;

use App\Models\Workout\Workout;
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

    public $durationFrom = 0;
    public $durationTo;
    public $initialDurationTo;


    public function updated()
    {        
        $this->resetPage();
    }

    public function mount() {
        $this->dateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(Workout::max('created_at')));
        $this->initialDateTo = date('Y-m-d', strtotime(Workout::max('created_at')));

        $this->durationTo = Workout::max('duration');
        $this->initialDurationTo = Workout::max('duration');
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

        $this->durationFrom = 0;
        $this->durationTo = Workout::max('duration');
    }

    public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Workout::min('created_at')));
        $this->dateTo = date('Y-m-d', strtotime(Workout::max('created_at')));
    }

    public function clearFilterDuration()
    {
        $this->durationFrom = 0;
        $this->durationTo = Workout::max('duration');
    }

    public function clearFilterTipo()
    {
        $this->tipo = 0;
    }

    public function clearSearch()
    {
        $this->search = '';
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

        // Main Selection, Join tables code_entries, code_categories and code_entry_tag
        $entries = Workout::select(
            'workouts.id as id',
            'workout_types.name as type_name',            
            'workouts.title as title',
            'workouts.author as author',
            'workouts.duration as duration',
            'workouts.url as url',
            'workouts.description as description',
            'workouts.created_at as created',
        )
            ->join('workout_types', 'workouts.type_id', '=', 'workout_types.id')
            ->distinct('workouts.id')
            ->orderby($this->orderColumn, $this->sortOrder);

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $entries = $entries->whereDate('workouts.created_at', '>=', $this->dateFrom)
                ->whereDate('workouts.created_at', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }  

        // tipo filter
        if ($this->tipo != 0) {
            $entries = $entries->where('workout_types.name', '=', $this->tipo);
        }

        // interval duration filter
        if ($this->durationFrom <= $this->durationTo) {
            $entries = $entries->whereBetween('workouts.duration', [$this->durationFrom, $this->durationTo]);
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
        $totalDuration = $stats->get()->sum('duration');


        $entries = $entries->paginate($this->perPage);

        return view('livewire.workout.workout-index', [
            'entries' => $entries,
            'found' => $found,
            'total' => $totalEntries,
            'differentTypes' => $differentTypes,
            'column' => $this->orderColumn,
            'types' => $types,
            'totalDuration' => $totalDuration,
        ])->layout('layouts.app');
    }
}

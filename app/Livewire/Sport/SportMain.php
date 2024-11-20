<?php

namespace App\Livewire\Sport;

use App\Models\Sport\Sport;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportTag;
use App\Services\SportService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class SportMain extends Component
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

    public $pending = 2;
    public $dateFrom = '';
    public $initialDateFrom;
    public $dateTo = '';
    public $initialDateTo;
    #[Url(as: 'c', except: '')]
    public $cat = 0;
    #[Url(as: 'ta', except: '')]
    public $selectedTags = [];

    public $durationFrom;
    public $initialDurationFrom;
    public $durationTo;
    public $initialDurationTo;

    public $distanceFrom;
    public $initialDistanceFrom;
    public $distanceTo;
    public $initialDistanceTo;

    // multiple batch selections
    public $selections = [];   

    // select all
    public $selectAll = false;

    // Dependency Injection CodeService to get the Types Categories and Tags
    protected SportService $sportService;

    public function boot(
        SportService $sportService,
    ) {
        $this->sportService = $sportService;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function mount() {
        $this->dateFrom = date('Y-m-d', strtotime(Sport::min('date')));
        $this->initialDateFrom = date('Y-m-d', strtotime(Sport::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Sport::max('date')));
        $this->initialDateTo = date('Y-m-d', strtotime(Sport::max('date')));
        $this->durationFrom = Sport::min('duration');
        $this->initialDurationFrom = Sport::min('duration');
        $this->durationTo = Sport::max('duration');
        $this->initialDurationTo = Sport::max('duration');
        $this->distanceFrom = Sport::min('distance');
        $this->initialDistanceFrom = Sport::min('distance');
        $this->distanceTo = Sport::max('distance');
        $this->initialDistanceTo = Sport::max('distance');
    }   

    // prefix updated method to access the value of the variable wired
    public function updatedSelectAll($value)
    {        
        if ($value) {
            $this->selections = Sport::pluck('id')->toArray();
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
        $this->pending = 2;
        $this->dateFrom = date('Y-m-d', strtotime(Sport::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Sport::max('date')));
        $this->cat = 0;
        $this->selectedTags = [];
        $this->durationFrom = Sport::min('duration');
        $this->durationTo = Sport::max('duration');
        $this->distanceFrom = Sport::min('distance');
        $this->distanceTo = Sport::max('distance');
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function clearFilterStatus()
    {
        $this->pending = 2;
    }
    
    public function clearFilterDate()
    {
        $this->dateFrom = date('Y-m-d', strtotime(Sport::min('date')));
        $this->dateTo = date('Y-m-d', strtotime(Sport::max('date')));
    }

    public function clearFilterCategory()
    {
        $this->cat = 0;
    }

    public function clearFilterTag()
    {
        $this->selectedTags = [];
    }

    public function clearFilterDuration()
    {
        $this->durationFrom = Sport::min('duration');
        $this->durationTo = Sport::max('duration');
    }

    public function clearFilterDistance()
    {
        $this->distanceFrom = Sport::min('distance');
        $this->distanceTo = Sport::max('distance');
    }

    public function bulkClear()
    {
        $this->selections = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        
        $result = $this->sportService->bulkDeleteSports($this->selections);

        return to_route('sports.index')->with('message', $result);
    }

    public function resetAll()
    {
        $this->clearFilters();
        $this->clearSearch();
        $this->bulkClear();
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

        // get only the categories that have at least one sport entry
        $categories = Sport::select(
            'sport_categories.id as id',
            'sport_categories.name as name'
        )
            ->join('sport_categories', 'sports.category_id', '=', 'sport_categories.id')->distinct('category_id')->orderBy('name', 'asc')->get()->toArray();       

        // get only the tags that have at least one sport entry    
        $tags = SportTag::select(
            'sport_tags.id as id',
            'sport_tags.name as name'
        )
            ->join('sports_tag', 'sports_tag.sport_tag_id', '=', 'sport_tags.id')->distinct('sport_tags.id')->orderBy('name', 'asc')->get()->toArray();

        // Main Selection, Join tables sports, sport_categories and sports_tag
        $entries = Sport::select(
            'sports.id as id',
            'sport_categories.name as category_name',
            'sports.title as title',
            'sports.user_id as user_id',
            'sports.status as status',
            'sports.location as location',
            'sports.duration as duration',
            'sports.distance as distance',
            'sports.url as url',
            'sports.info as info',
            'sports.date as date',
            'sports.created_at as created_at',
            //'sport_images.id as files'
        )
            ->join('sport_categories', 'sports.category_id', '=', 'sport_categories.id')
            ->join('sports_tag', 'sports.id', '=', 'sports_tag.sport_id')
            //->join('sport_images', 'sports.id', '=', 'sport_images.sport_id')
            ->distinct('sports.id')
            ->orderby($this->orderColumn, $this->sortOrder);

        // Select the entries for the current user
        $user = Auth::user();
        $entries = $entries->where('user_id', '=', $user->id);
            
        // status filter
        if ($this->pending != 2) {
            $entries = $entries->where('status', '=', $this->pending);
        }    

        // interval date filter
        if (isset($this->dateFrom)) {
            if ($this->dateFrom <= $this->dateTo) {                                
                $entries = $entries->whereDate('date', '>=', $this->dateFrom)
                ->whereDate('date', '<=', $this->dateTo);
            }
            else {
                //dd('errorcito');
            }
        }
        
        // category filter
        if ($this->cat != 0) {
            $entries = $entries->where('sport_categories.name', '=', $this->cat);
        }

        // tags filter        
        if (!in_array('0', $this->selectedTags) && (count($this->selectedTags) != 0)) {
            $entries = $entries->whereIn('sports_tag.sport_tag_id', $this->selectedTags);
        }

        // interval duration filter
        if ($this->durationFrom <= $this->durationTo) {
            $entries = $entries->whereBetween('duration', [$this->durationFrom, $this->durationTo]);
        }

        // interval distance filter   
        if ($this->distanceFrom <= $this->distanceTo) {
            $entries = $entries->whereBetween('distance', [$this->distanceFrom, $this->distanceTo]);
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
        $totalDistance = $stats->get()->sum('distance');
        $totalDuration = $stats->get()->sum('duration');
        $differentCategories = $stats->distinct('sport_categories.id')->count();
        $differentLocations = $stats->distinct('location')->count();
        $differentDates = $stats->distinct('date')->count();

        $entries = $entries->paginate($this->perPage);

        if (!in_array('0', $this->selectedTags)) {
            $tagNames = $this->sportService->getTagNames($this->selectedTags);
        } else {
            $tagNames = [];
        }

        return view('livewire.sport.sport-main', [
            'entries' => $entries,
            'found' => $found,
            'total' => $totalEntries,
            'differentLocations' => $differentLocations,
            'differentCategories' => $differentCategories,
            'differentDates' => $differentDates,
            'totalDistance' => $totalDistance,
            'totalDuration' => $totalDuration,
            'column' => $this->orderColumn,
            'categories' => $categories,
            'tags' => $tags,
            'tagNames' => $tagNames
        ])->layout('layouts.app');
    }
}

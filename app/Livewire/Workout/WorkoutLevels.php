<?php

namespace App\Livewire\Workout;

use App\Models\Workout\WorkoutLevel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class WorkoutLevels extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $orderColumn = "workout_levels.id";
    public $sortOrder = "desc";
    public $sortLink = '<i class="fa-solid fa-caret-down"></i>';
    public $search = "";
    public $perPage = 25;

    public $selections = [];

    public function updated()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = "";
    }

    public function bulkClear()
    {
        $this->selections = [];
    }

    public function bulkDelete()
    {
        foreach ($this->selections as $selection) {
            $level = WorkoutLevel::find($selection);
            $level->delete();
        }

        return to_route('wk_levels.index')/* ->with('message', 'levels successfully deleted.') */;
    }

    public function sorting($columnName = "")
    {
        $caretOrder = "up";
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
        
        //$levels = WorkoutLevel::orderby($this->orderColumn, $this->sortOrder)->select('*');

        $levels = WorkoutLevel::orderby($this->orderColumn, $this->sortOrder)->select(
            'workout_levels.id as id',
            'workout_levels.name as name',
            'workout_levels.created_at as created_at',
            'workout_levels.updated_at as updated_at'
        )
            ->join('workouts', 'workouts.level_id', '=', 'workout_levels.id')
            ->where('user_id', Auth::id());  

        if (!empty($this->search)) {

            $found = $levels->where('name', "like", "%" . $this->search . "%")->count();
        }

        $total = $levels->count();

        $levels = $levels->paginate($this->perPage);

        return view('livewire.workout.workout-levels', [
            'levels'    => $levels,
            'found'     => $found,
            'column'    => $this->orderColumn,
            'total'     => $total
        ])->layout('layouts.app');
    }
    
}

<?php

namespace App\Livewire\Workout;


use App\Models\Workout\WorkoutType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Calculation\Web;
use Illuminate\Support\Facades\Auth;

class WorkoutTypes extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";
    public $orderColumn = "workout_types.id";
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
            $type = WorkoutType::find($selection);
            $type->delete();
        }

        return to_route('wk_types.index')/* ->with('message', 'Types successfully deleted.') */;
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

        // TODO: workouts total as column to order        

        /* Query builder */
        /* $types = WorkoutType::leftjoin('workouts', 'workout_types.id', '=', 'workouts.type_id')
        ->select('workout_types.name', 'workout_types.id as id','workout_types.created_at','workout_types.updated_at', DB::raw('count(workouts.id) as total'))
        ->groupBy('workout_types.name', 'workout_types.id', 'workout_types.created_at', 'workout_types.updated_at')
        ->orderby($this->orderColumn, $this->sortOrder); */
        
        $types = WorkoutType::orderby($this->orderColumn, $this->sortOrder)->select('*');       

        /* $types = WorkoutType::orderby($this->orderColumn, $this->sortOrder)->select(
            'workout_types.id as id',
            'workout_types.name as name',
            'workout_types.created_at as created_at',
            'workout_types.updated_at as updated_at'
        )
            ->join('workouts', 'workouts.type_id', '=', 'workout_types.id')
            ->where('user_id', Auth::id());         */
                    
        
        if (!empty($this->search)) {

            $found = $types->where('name', "like", "%" . $this->search . "%")->count();
        }

        $total = $types->count();
        $types = $types->paginate($this->perPage);

        return view('livewire.workout.workout-types', [
            'types'     => $types,
            'found'     => $found,
            'column'    => $this->orderColumn,
            'total'     => $total,
        ])->layout('layouts.app');
    }
}

<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workout\StoreLevelRequest;
use Illuminate\Http\Request;

use App\Models\Workout\WorkoutLevel;
use Exception;

class WorkoutLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLevelRequest $request, WorkoutLevel $level)
    {
        $formData = $request->validated();
        try {
            WorkoutLevel::where('id', $level->id)->update($formData);
            return to_route('wk_levels.show', $level)->with('message', 'Level successfully updated');
        } catch (Exception $e) {
            return to_route('wk_levels.show', $level)->with('message', 'Error(' . $e->getCode() . ') Level can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutLevel $level)
    {
        /* resticted access - only user who owns the level has access
        if ($level->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $level->delete();
            return to_route('wk_levels.index')->with('message', 'Type (' . $level->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('wk_levels.index')->with('message', 'Error (' . $e->getCode() . ') Type: ' . $level->name . ' can not be deleted.');
        }
    }
}

<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout\Workout;
use App\Services\WorkoutService;

use Illuminate\Http\Request;

use Exception;

class WorkoutController extends Controller
{
    public function __construct(private WorkoutService $workoutService) {        
    }
    
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout)
    {
         /* resticted access - only user who owns the type has access
        if ($type->user_id !== request()->user()->id) {
            abort(403);
        }*/
       
        // First delete the files associated to this workout
        $files = $workout->files;

        if ($files->count() > 0) {
            $this->workoutService->deleteFiles($files);
        }  
        // Delete the workout entry in the DB
        try {
            $workout->delete();
            return to_route('workouts.index')->with('message', 'Workout (' . $workout->title . ') successfully deleted.');
        } catch (Exception $e) {
            return to_route('workouts.index')->with('message', 'Error (' . $e->getCode() . ') Workout: ' . $workout->title . ' can not be deleted.');
        }
    }
}

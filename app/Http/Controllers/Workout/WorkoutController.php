<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout\Workout;
use App\Services\WorkoutService;

use Illuminate\Http\Request;

use Exception;

class WorkoutController extends Controller
{
    public function __construct(private WorkoutService $workoutService)
    {
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

        $result = $this->workoutService->deleteWorkout($workout);

        return to_route('workouts.index')->with('message', $result);
       
    }
}

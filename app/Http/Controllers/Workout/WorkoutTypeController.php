<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workout\StoreTypeRequest;
use App\Models\Workout\WorkoutType;
use Illuminate\Http\Request;

use Exception;

class WorkoutTypeController extends Controller
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
    public function update(StoreTypeRequest $request, WorkoutType $type)
    {
        $formData = $request->validated();
        try {
            WorkoutType::where('id', $type->id)->update($formData);
            return to_route('wk_types.show', $type)->with('message', 'Type successfully updated');
        } catch (Exception $e) {
            return to_route('wk_types.show', $type)->with('message', 'Error(' . $e->getCode() . ') Type can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutType $type)
    {
        /* resticted access - only user who owns the type has access
        if ($type->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $type->delete();
            return to_route('wk_types.index')->with('message', 'Type (' . $type->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('wk_types.index')->with('message', 'Error (' . $e->getCode() . ') Type: ' . $type->name . ' can not be deleted.');
        }
    }
}

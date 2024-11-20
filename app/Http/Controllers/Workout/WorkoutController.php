<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout\Workout;
use App\Services\FileService;
use App\Services\WorkoutService;

use Illuminate\Http\Request;

use Exception;

class WorkoutController extends Controller
{
    public function __construct(private FileService $fileService)
    {
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


        try {
            $files = $workout->files;
            $result = $workout->delete();

            // If the Workout Entry is deleted, check if there is associated files and delete them.
            if ($result) {
                if ($files->isNotEmpty()) {
                    $this->fileService->deleteFiles($files);
                }

                return to_route('workouts.index')->with('message', 'Workout (' . $workout->title . ') successfully deleted.');
            } else {
                return to_route('workouts.index')->with('message', 'Error - Workout: ' . $workout->title . ' can not be deleted.');
            }
        } catch (Exception $e) {
            return to_route('workouts.index')->with('message', 'Error (' . $e->getCode() . ') Workout: ' . $workout->title . ' can not be deleted.');
        }
    }
}

<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use Exception;
use Illuminate\Http\Request;

class SportController extends Controller
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        /* resticted access - only user who owns the type has access
        if ($type->user_id !== request()->user()->id) {
            abort(403);
        }*/

        // First delete the files associated to this workout
        /*  $files = $workout->files;

        if ($files->count() > 0) {
            $this->workoutService->deleteFiles($files);
        }   */
        // Delete the workout entry in the DB
        //dd($sport);

        try {
            
            $result = $sport->delete();

            if ($result) {
                return to_route('sports.index')->with('message', 'Sport (' . $sport->title . ') successfully deleted.');
            } else {
                return to_route('sports.index')->with('message', 'Error - Sport: ' . $sport->title . ' can not be deleted.');
            }
            
        } catch (Exception $e) {
            return to_route('sports.index')->with('message', 'Error (' . $e->getCode() . ') Sport: ' . $sport->title . ' can not be deleted.');
        }
    }
}

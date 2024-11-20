<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SportController extends Controller
{
    public function __construct(private FileService $fileService) {        
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
    public function destroy(Sport $sport)
    {              
         // resticted access - only user who owns the Sport has access
         if ($sport->user_id !== Auth::id()) {
            abort(403);
        }   

        try {
            
            $files = $sport->files;           
            $result = $sport->delete();

            // If the Sport Entry is deleted, check if there is associated files and delete them.
            if ($result) {
                
                if($files->isNotEmpty()) {
                    $this->fileService->deleteFiles($files);
                }                

                return to_route('sports.index')->with('message', 'Sport (' . $sport->title . ') successfully deleted.');

            } else {

                return to_route('sports.index')->with('message', 'Error - Sport: ' . $sport->title . ' can not be deleted.');
            }
            
        } catch (Exception $e) {
            return to_route('sports.index')->with('message', 'Error (' . $e->getCode() . ') Sport: ' . $sport->title . ' can not be deleted.');
        }
    }
}

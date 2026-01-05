<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutFile;
use App\Services\FileService;
use Illuminate\Http\Request;

class WorkoutFileController extends Controller
{
        
    public function __construct(private FileService $fileService) {        
    }
    
    public function download(Workout $workout, WorkoutFile $file)
    {
        return $this->fileService->downloadFile($file, 'attachment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout, WorkoutFile $file)
    {          
        $this->fileService->deleteOneFile($file);
        
        return back()->with('message', 'File ' . $file->original_filename . ' from Workout: ' . $workout->title . ' deleted.');
    }
}

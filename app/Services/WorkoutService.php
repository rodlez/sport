<?php

namespace App\Services;

// Models
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutFile;
use App\Models\Workout\WorkoutType;

// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;


class WorkoutService
{

    /**
     *  Get all the types orderby asc
     */
    public function getTypes(): Collection
    {
        return WorkoutType::orderBy('name')->get();
    }


     /**
     * Upload a file and return an array with the info to make the insertion in the DB table 
     */

     public function uploadFile(mixed $request, Workout $workout, string $disk, string $storagePath): array
     {  
       
        // Info to store in the DB
         $original_filename = $request->getClientOriginalName();
         $media_type = $request->getMimeType();
         $size = $request->getSize();                 
         // Storage in filesystem file config, specify the storagePath
         $path = Storage::disk($disk)->putFile($storagePath, $request);
         $storage_filename = basename($path);
 
         return [
             'workout_id' => $workout->id,
             'original_filename' => $original_filename,
             'storage_filename' => $storage_filename,
             'path' => $path,
             'media_type' => $media_type,
             'size' => $size,
         ];
     }

     /**
     * Download a file, disposition inline(browser) or attachment(download)
     */

    public function downloadFile(WorkoutFile $file, string $disposition)
    {
        // No need to specify the disposition to download the file.

        $dispositionHeader = [
            'Content-Disposition' => $disposition,
        ];

        if (Storage::disk('public')->exists($file->path)) {
            //return Storage::disk('public')->download($file->path, $file->original_filename, $dispositionHeader);
            return Storage::disk('public')->download($file->path, $file->original_filename);
        } else {
            return back()->with('message', 'Error: File ' . $file->original_filename . ' can not be downloaded.');
        }
    }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteFiles(Collection $files)
    {
        foreach ($files as $file) {
            $this->deleteOneFile($file);
        }
    }

    /**
     * Inset new Note and insert the tags in the intermediate table note_tag
     */
    public function deleteOneFile(WorkoutFile $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            /*  echo $file->path;
             dd('borradito'); */
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
    }


}
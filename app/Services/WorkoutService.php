<?php

namespace App\Services;

// Models
use App\Models\Workout\Workout;
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


}
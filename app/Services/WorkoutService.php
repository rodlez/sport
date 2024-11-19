<?php

namespace App\Services;

// Models
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutFile;
use App\Models\Workout\WorkoutType;
use App\Models\Workout\WorkoutLevel;

use App\Models\Sport\Sport;
// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;
use stdClass;

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
     *  Get all the levels orderby id
     */
    public function getLevels(): Collection
    {
        return WorkoutLevel::orderBy('id')->get();
    }

     /**
     *  Get the paths for the videos uploaded for this Workout, if there is any
     */
    public function getSportPlaylist(Sport $sport): array
    {
        $playlist = [];
        
        $workouts = $sport->workouts()->whereNotNull('url')->select('title', 'url')->get();

        //dd($workouts);

        foreach ($workouts as $workout) {
            //echo $workout->pivot->workout_id;
            /* $file = $workout->whereNotNull('url')->select('title', 'url')->get();
            dd($file); */
            //$file = $workout->files()->get();
            $playlist [] = $workout;
        }

        return $playlist;
    }

    /**
     *  Get the paths for the videos uploaded for this Workout, if there is any
     */
    public function getSportVideoPaths(Sport $sport): array
    {
        $videos = [];

        $workouts = $sport->workouts()->get();

        foreach ($workouts as $workout) {
            //echo $workout->pivot->workout_id;
            $file = $workout->files()->where('media_type', 'video/mp4')->select('original_filename', 'path')->get();
            //$file = $workout->files()->get();
            $videos[] = $file;
        }

        return $videos;
    }

    /**
     *  Get the number of video files for a given Sport Entry
     */
    public function getVideosTotal(array $videos): int
    {
        return array_sum(array_map('count', $videos));
    }

    /**
     *  Get the paths for the videos uploaded for this Workout, if there is any
     */
    public function getVideos(Workout $workout): array
    {
        $videos = [];

        foreach ($workout->files as $key => $file) {
            if ($file->media_type == 'video/mp4') {
                $videos[] = $file->path;
            }
        }

        //dd($videos);

        return $videos;
    }

    /**
     *  Get the paths for the videos uploaded for this Workout, if there is any
     */
    public function getVideosito(Workout $workout): array
    {
        $videos = [];

        foreach ($workout->files as $key => $file) {
            if ($file->media_type == 'video/mp4') {
                $videos[] = $file;
            }
        }

        //dd($videos[0]);

        return $videos;
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

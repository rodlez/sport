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
use Exception;
// Redirect
use Illuminate\Http\RedirectResponse;
// Service
use App\Services\FileService;


class WorkoutService
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * Given a Workout delete it from the Database and delete all the associated files if any from the Database and Disk
     * 
     * Return a message string to use in the redirection in the Controller.
     *
     * @param  Workout $workout
     * @return string
     */
    public function deleteWorkout(Workout $workout): string
    {
        $message = '';
        
        try {
            $files = $workout->files;
            $result = $workout->delete();

            // If the Workout Entry is deleted, check if there is associated files and delete them.
            if ($result) {
                if ($files->isNotEmpty()) {
                    $this->fileService->deleteFiles($files);
                }
                
                $message = 'Workout (' . $workout->title . ') successfully deleted.';                
            } else {
                $message = 'Error - Workout: ' . $workout->title . ' can not be deleted.';
            }
        } catch (Exception $e) {            
            $message = 'Error (' . $e->getCode() . ') Workout: ' . $workout->title . ' can not be deleted.';
        } 
        return $message;
    }

    /**
     * Given an array with Workout ids, delete them from the Database and also delete all the associated files if any from the Database and Disk
     * 
     * Return a message string to use in the redirection in the Controller.
     *
     * @param  array $workoutIds
     * @return string
     */
    public function bulkDeleteWorkouts(array $workoutIds)
    {
        $message = '';

        try {
        
            foreach ($workoutIds as $workoutId) {
                $workout = Workout::find($workoutId);
                
                $files = $workout->files;
                $result = $workout->delete();

                if ($result) {
                    if ($files->isNotEmpty()) {
                        $this->fileService->deleteFiles($files);
                    }                
                }
            } 
            $message = 'Workout(s) successfully deleted.';    
        }
        catch (Exception $e) {            
            $message = 'Error (' . $e->getCode() . ') Workout(s) can not be deleted.';
        } 
        
        return $message;        
       
    }



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

   
}

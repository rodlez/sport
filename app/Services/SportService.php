<?php

namespace App\Services;

// Models
use App\Models\Sport\Sport;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportFile;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;
use Exception;
class SportService
{
    public function __construct(private FileService $fileService)
    {
    }

     /**
     * Given a Sport delete it from the Database and delete all the associated files if any from the Database and Disk
     * 
     * Return a message string to use in the redirection in the Controller.
     *
     * @param  Sport $sport
     * @return string
     */
    public function deleteSport(Sport $sport): string
    {
        $message = '';
        
        try {
            $files = $sport->files;
            $result = $sport->delete();

            // If the Workout Entry is deleted, check if there is associated files and delete them.
            if ($result) {
                if ($files->isNotEmpty()) {
                    $this->fileService->deleteFiles($files);
                }
                
                $message = 'Sport (' . $sport->title . ') successfully deleted.';                
            } else {
                $message = 'Error - Sport: ' . $sport->title . ' can not be deleted.';
            }
        } catch (Exception $e) {            
            $message = 'Error (' . $e->getCode() . ') Sport: ' . $sport->title . ' can not be deleted.';
        } 
        return $message;
    }

     /**
     * Given an array with Sport ids, delete them from the Database and also delete all the associated files if any from the Database and Disk
     * 
     * Return a message string to use in the redirection in the Controller.
     *
     * @param  array $sportIds
     * @return string
     */
    public function bulkDeleteSports(array $sportIds)
    {
        $message = '';

        try {
        
            foreach ($sportIds as $sportId) {
                $sport = Sport::find($sportId);
                
                $files = $sport->files;
                $result = $sport->delete();

                if ($result) {
                    if ($files->isNotEmpty()) {
                        $this->fileService->deleteFiles($files);
                    }                
                }
            } 
            $message = 'Sport(s) successfully deleted.';    
        }
        catch (Exception $e) {            
            $message = 'Error (' . $e->getCode() . ') Sport(s) can not be deleted.';
        } 
        
        return $message;        
       
    }
    
    /**
     * Inset new Sport and insert the tags in the pivot table sports_tag and if any, the workouts in the pivot table sports_workouts
     */
    public function insertSport(array $data): Sport
    {
        // If category_id is NOT 12 (Workout), selectedWorkouts must be empty
        if ($data['category_id'] != 2) {
            $data['selectedWorkouts'] = [];
        }

        $sport = Sport::create($data);
        $sport->tags()->sync($data['selectedTags']);
        $sport->workouts()->sync($data['selectedWorkouts']);

        return $sport;
    }

    /**
     * Inset new Sport and update the tags in the pivot table sports_tag and if any, the workouts in the pivot table sports_workouts
     */
    public function updateSport(Sport $sport,array $data): Sport
    {
        // If category_id is NOT 12 (Workout), selectedWorkouts must be empty
        if ($data['category_id'] != 2) {
            $data['selectedWorkouts'] = [];
        }       
       
        $sport->update($data);
        $sport->tags()->sync($data['selectedTags']);
        $sport->workouts()->sync($data['selectedWorkouts']);

        return $sport;
    }

    /**
     *  Get all the categories orderby asc
     */
    public function getCategories(): Collection
    {
        return SportCategory::orderBy('name')->get();
    }

    /**
     *  Get all the tags orderby asc
     */
    public function getTags(): Collection
    {
        return SportTag::orderBy('name')->get();
    }

    /**
     *  Get the tags Ids associated to this Sport entry
     */
    public function getSportEntryTags(Sport $sport): array
    {
        $tags = [];
        foreach ($sport->tags as $tag) {
            $tags[] = $tag->pivot->sport_tag_id;
        }

        return $tags;
    }

    /**
     *  Get the workouts Ids associated to this Sport entry
     */
    public function getSportEntryWorkouts(Sport $sport): array
    {
        $tags = [];
        foreach ($sport->workouts as $workout) {
            $tags[] = $workout->pivot->workout_id;
        }

        return $tags;
    }

    /**
     *  Get all the workouts orderby asc
     */
    public function getWorkouts(): Collection
    {
        return Workout::orderBy('title')->get();
    }

    /**
     * Get the tag names given an array with the tag ids
     */

    public function getTagNames(array $tags): array
    {
        $tagsNames = [];
        foreach ($tags as $key => $value) {
            $tagInfo = SportTag::find($value);
            $tagsNames[] = $tagInfo->name;
        }
        return $tagsNames;
    }


    /**
     *  Get array with the name of the tags for this entry
     * 
     * @param Sport $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function getSportTagsNames(Sport $entry): array
    {
        $tags = $entry->tags;        
        $result = [];

        foreach ($tags as $tag) {         
                $result[] = $tag->name;         
        }

        return $result;
    }

    /**
     *  Get array with the name of the tags for this entry
     * 
     * @param Sport $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function getSportWorkoutsTitles(Sport $entry): array
    {
        $workouts = $entry->workouts;        
        $result = [];

        foreach ($workouts as $workout) {         
                $result[] = $workout->title;         
        }

        return $result;
    }

    /**
     *  Get tags for this entry
     * 
     * @param Sport $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    /* public function displaySportEntryRelatedTags(Sport $entry, string $separator): array
    {
        $tags = $entry->tags;
        $count = 0;
        $result = [];

        foreach ($tags as $tag) {
            $count++;
            if ($count == count($tags))
                $result[] = $tag->name;

            else {
                $result[] = $tag->name . ' ' . $separator . ' ';
            }
        }

        return $result;
    } */

}

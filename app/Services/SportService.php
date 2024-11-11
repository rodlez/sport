<?php

namespace App\Services;

// Models
use App\Models\Sport\Sport;
use App\Models\Sport\SportCategory;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;

class SportService
{
    /**
     * Inset new Sport and insert the tags in the pivot table sports_tag and if any, the workouts in the pivot table sports_workouts
     */
    public function insertSport(array $data): Sport
    {
        // If category_id is NOT 12 (Workout), selectedWorkouts must be empty
        if ($data['category_id'] != 12) {
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
        if ($data['category_id'] != 12) {
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
     *  Get tags for this entry
     * 
     * @param Sport $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function displaySportEntryRelatedTags(Sport $entry, string $separator): array
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
    }
}

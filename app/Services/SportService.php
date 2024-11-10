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
        $sport = Sport::create($data);
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
}

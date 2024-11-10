<?php

namespace App\Services;

// Models
use App\Models\Sport\Sport;
use App\Models\Sport\SportTag;
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutFile;
use App\Models\Workout\WorkoutType;

// Files
use Illuminate\Support\Facades\Storage;

// Collection
use Illuminate\Database\Eloquent\Collection;


class SportService
{



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
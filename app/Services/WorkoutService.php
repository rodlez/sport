<?php

namespace App\Services;

// Models
use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutType;

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



}
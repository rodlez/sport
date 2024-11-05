<?php

namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutType extends Model
{
    use HasFactory;
    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'name'
    ];

    /**
     * Get the entries associated with the category.
     */
    /* public function workouts()
    {
        return $this->hasMany(
            Workout::class,
            foreignKey: 'type_id'
        );
    } */

}

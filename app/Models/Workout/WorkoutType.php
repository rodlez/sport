<?php

namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class WorkoutType extends Model
{
    use HasFactory;
    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = ['name'];

    /**
     * Get the entries associated with the category.
     */
    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class, foreignKey: 'type_id');
    }

   /**
     * Get the sport entries associated with the category for the current User.
     */
    public function workoutsUser()
    {
        return $this->hasMany(
            Workout::class,
            foreignKey: 'type_id'
        )->where('user_id', Auth::id());
    }


}

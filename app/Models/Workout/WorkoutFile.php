<?php

namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutFile extends Model
{
    use HasFactory;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'workout_id',
        'original_filename',
        'storage_filename',
        'path',
        'media_type',
        'size'
    ];

    /**
     * Get the Woirkout entry associated with the file.
     */
    public function workouts()
    {
        return $this->belongsTo(
            Workout::class,
            foreignKey: 'workout_id'
        );
    }
}

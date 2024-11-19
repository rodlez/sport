<?php

namespace App\Models\Workout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [        
        'type_id',
        'level_id',        
        'title',
        'author',
        'duration',
        'url',
        'description'
    ];

     /**
     * Get the type associated.
     */
    public function type()
    {
        return $this->belongsTo(
            WorkoutType::class,
            foreignKey: 'type_id'
        );
    }

     /**
     * Get the level associated.
     */
    public function level()
    {
        return $this->belongsTo(
            WorkoutLevel::class,
            foreignKey: 'level_id'
        );
    }

    /**
     * Get the Files associated.
     */
    public function files()
    {
        return $this->hasMany(
            WorkoutFile::class,
            foreignKey: 'workout_id'
        );
    }


}

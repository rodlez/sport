<?php

namespace App\Models\Sport;

use App\Models\User;
use App\Models\Workout\Workout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'title',
        'date',
        'location',
        'duration',
        'distance',
        'url',
        'info'
    ];

     /**
     * Get the user associated with the Sport.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            foreignKey: 'user_id'
        );
    }

    /**
     * Get the category associated with the Sport.
     */
    public function category()
    {
        return $this->belongsTo(
            SportCategory::class,
            foreignKey: 'category_id'
        );
    }

    /**
     * Get the tags associated with the Sport.
     */
    public function tags()
    {
        return $this->belongsToMany(
            SportTag::class,
            table: 'sports_tag',
            foreignPivotKey: 'sport_id'
        )->withTimestamps();
    }

    /**
     * Get the workouts associated with the Sport.
     */
    public function workouts()
    {
        return $this->belongsToMany(
            Workout::class,
            table: 'sports_workouts',
            foreignPivotKey: 'sport_id'
        )->withTimestamps();
    }

    /**
     * Get the Files associated.
     */
    public function files()
    {
        return $this->hasMany(
            SportFile::class,
            foreignKey: 'sport_id'
        );
    }

}

<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportTag extends Model
{
    use HasFactory;
    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = ['name'];

    /**
     * Get the sport entries associated with the category.
     */
    public function sports()
    {
        return $this->belongsToMany(
            Sport::class,
            table: 'sports_tag',
            relatedPivotKey: 'sport_id'
        )->withTimestamps();
    }

}

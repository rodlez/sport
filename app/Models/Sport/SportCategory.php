<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Facades\Auth;

class SportCategory extends Model
{
    use HasFactory;
    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = ['name'];

    /**
     * Get the sport entries associated with the category.
     */
    public function sports()
    {
        return $this->hasMany(
            Sport::class,
            foreignKey: 'category_id'
        );
    }

    /**
     * Get the sport entries associated with the category for the current User.
     */
    public function sportsUser()
    {
        return $this->hasMany(
            Sport::class,
            foreignKey: 'category_id'
        )->where('user_id', Auth::id());
    }
    

}

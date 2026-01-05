<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportFile extends Model
{
    use HasFactory;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'sport_id',
        'original_filename',
        'storage_filename',
        'path',
        'media_type',
        'size'
    ];

    /**
     * Get the Sport entry associated with the file.
     */
    public function sports()
    {
        return $this->belongsTo(
            Sport::class,
            foreignKey: 'sport_id'
        );
    }
}

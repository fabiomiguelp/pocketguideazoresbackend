<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TripCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->withTimestamps();
    }
}

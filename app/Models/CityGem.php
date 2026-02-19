<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityGem extends Model
{
    protected $fillable = [
        'city_id',
        'name',
        'description',
        'tip',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}

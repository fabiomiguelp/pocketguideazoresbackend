<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'island_id',
        'name',
    ];

    public function island(): BelongsTo
    {
        return $this->belongsTo(Island::class);
    }

    public function gems(): HasMany
    {
        return $this->hasMany(CityGem::class);
    }
}

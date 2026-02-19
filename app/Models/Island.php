<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Island extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }
}

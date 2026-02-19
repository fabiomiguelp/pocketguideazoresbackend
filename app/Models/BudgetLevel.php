<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetLevel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'min_budget',
        'max_budget',
    ];

    protected function casts(): array
    {
        return [
            'min_budget' => 'integer',
            'max_budget' => 'integer',
        ];
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}

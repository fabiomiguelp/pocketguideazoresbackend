<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'island_id',
        'budget_level_id',
        'city_id',
        'num_adults',
        'num_children',
        'duration_days',
        'has_car',
        'itinerary',
    ];

    protected function casts(): array
    {
        return [
            'num_adults'    => 'integer',
            'num_children'  => 'integer',
            'duration_days' => 'integer',
            'has_car'       => 'boolean',
            'itinerary'     => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function island(): BelongsTo
    {
        return $this->belongsTo(Island::class);
    }

    public function budgetLevel(): BelongsTo
    {
        return $this->belongsTo(BudgetLevel::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(TripCategory::class)->withTimestamps();
    }
}

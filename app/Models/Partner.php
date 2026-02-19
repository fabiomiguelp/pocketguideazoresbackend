<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'description',
        'island_id',
        'budget_level_id',
        'trip_category_id',
        'price',
        'contact',
        'link',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function island(): BelongsTo
    {
        return $this->belongsTo(Island::class);
    }

    public function budgetLevel(): BelongsTo
    {
        return $this->belongsTo(BudgetLevel::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TripCategory::class, 'trip_category_id');
    }
}

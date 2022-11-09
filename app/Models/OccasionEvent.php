<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OccasionEvent extends Model
{
    use HasFactory;

    public static function create(array $array)
    {
    }

    public static function truncate()
    {
    }

    public static function insert(array $array)
    {
    }

    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    public function occasionEventPrice(): HasMany
    {
        return $this->hasMany(OccasionEventPrice::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OccasionEvent extends Model
{
    use HasFactory;
    public function occasion()
    {
        return $this->hasMany(OccasionEventsPivot::class);
    }
    public function serviceType()
    {
        return $this->hasOne(ServiceType::class,'id','service_type');
    }

    public function occasionEventsReviews()
    {
        return $this->hasMany(OccasionEventReviews::class);
    }
    public function occasionEventPrice(): HasMany
    {
        return $this->hasMany(OccasionEventPrice::class);
    }
    public function occasionEventsReviewsAverage() {
        return $this->hasMany(OccasionEventReviews::class)
            ->selectRaw('avg(rate) as aggregate, occasion_event_id')
            ->groupBy('occasion_event_id');
    }
}

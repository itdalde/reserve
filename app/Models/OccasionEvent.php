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
    public function price()
    {
        return $this->hasOne(OccasionEventPrice::class);
    }
    public function serviceType()
    {
        return $this->hasOne(ServiceType::class,'id','service_type');
    }

    public function occasionEventsReviews()
    {
        return $this->hasMany(OccasionEventReviews::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(EventImages::class,'occasion_event_id');
    }
    public function occasionEventPrice(): HasMany
    {
        return $this->hasMany(OccasionEventPrice::class)->where('active', '=', 1);
    }
    public function occasionEventsReviewsAverage() {
        return $this->hasMany(OccasionEventReviews::class)
            ->selectRaw('avg(rate) as aggregate, occasion_event_id')
            ->groupBy('occasion_event_id');
    }

    public function orders() {
        return $this->hasMany(Transaction::class,'occasion_event_id','id');
    }
}

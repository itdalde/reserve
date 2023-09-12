<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccasionEvent extends Model
{
    use HasFactory;
    protected $table = 'services';

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
        return $this->hasMany(OrderItems::class,'service_id','id');
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Company::class, 'id', 'company_id');
    }
    public function provider(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    public function serviceRate() {
        return $this->hasMany(OccasionEventPrice::class)->where('active', '=', 1);
    }
    public function serviceReviews()
    {
        return $this->hasMany(OccasionEventReviews::class)->with(
                'user',
            )->where('status', 1);
    }
    public function ratings() {
        return $this->hasMany(OccasionEventReviews::class)
            ->selectRaw('avg(rate) as aggregate, occasion_event_id')
            ->groupBy('occasion_event_id');
    }
    public function availabilities() {
        return $this->hasMany(AvailableDates::class, 'service_id', 'id')
            ->where('status',1)
            ->selectRaw('DATE(date_obj) as date');
    }
    public function unavailabilities() {
        return $this->hasMany(AvailableDates::class, 'service_id', 'id')
            ->where('status',2)
            ->selectRaw('DATE(date_obj) as date');
    }
    public function paymentPlan()
    {
        return $this->hasOne(OccasionEventPrice::class, 'occasion_event_id', 'id');
    }

    public function gallery() {
        return $this->hasMany(EventImages::class);
    }

    public function adOns() {
        return $this->hasMany(OccasionEventAddon::class, 'occasion_event_id', 'id');
    }


    public function features() {
        return $this->hasMany(Feature::class, 'service_id', 'id');
    }

    public function conditions() {
        return $this->hasMany(Condition::class, 'service_id', 'id');
    }
    public function totalCompletedOrders()
    {
        return $this->hasMany(OrderItems::class, 'service_id', 'id')
            ->selectRaw('service_id, COUNT(id) as total')
            ->where('status', 'completed')
            ->groupBy('service_id');
    }

}

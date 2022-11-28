<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function serviceType() {
        return $this->belongsTo(ServiceType::class);
    }

    public function occasionEvents() {
        return $this->hasMany(OccasionEvent::class)->with(
            'serviceType',
            'occasionEventsReviews',
            'occasionEventPrice',
            'occasionEventsReviewsAverage');
    }
}

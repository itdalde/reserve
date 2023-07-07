<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    use HasFactory;

    public function occasionEvents() {
        return $this->hasMany(OccasionEvent::class,'occasion_type');
    }
    public function occasionEventsReviews() {
        return $this->hasMany(OccasionEventReviews::class);
    }
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function serviceTypes() {
        return $this->hasMany(OccasionServiceTypePivot::class,'occasion_id');
    }

}

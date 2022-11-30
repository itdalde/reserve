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

    public function services() {
        return $this->hasMany(OccasionEvent::class)->with(
            'serviceType',
            'serviceReviews',
            'serviceRate',
            'ratings');
    }

    public function tags() {
        return $this->hasMany(Tags::class);
    }

    public function reviews() {
        return $this->hasMany(CompanyReviews::class);
    }
}

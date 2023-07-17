<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function serviceType() {
        return $this->belongsTo(ServiceType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('roles');
    }
    public function services() {
        return $this->hasMany(OccasionEvent::class)->with(
            'serviceReviews',
            'paymentPlan',
            'serviceType',
            'ratings',
            'gallery',
            'availabilities',
            'company'
        )->where('active', '=', 1);
    }

    public function tags() {
        return $this->hasMany(Tags::class);
    }

    public function reviews() {
        return $this->hasMany(CompanyReviews::class);
    }
}

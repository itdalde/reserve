<?php

namespace App\Models;

use Google\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDates extends Model
{
    use HasFactory;

    public function service() {
        return $this->hasOne(OccasionEvent::class, 'id', 'service_id');
    }
    public function company() {
        return $this->hasOne(Company::class, 'company_id', 'id');
    }
}

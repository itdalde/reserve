<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    public function vendors()
    {
        return $this->hasMany(OccasionEvent::class, 'service_type', 'id')
            ->select('id', 'name', 'active');
    }
}

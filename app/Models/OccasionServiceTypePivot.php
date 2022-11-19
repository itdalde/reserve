<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionServiceTypePivot extends Model
{
    use HasFactory;

    public function occasions()
    {
        return $this->hasMany(Occasion::class, 'id', 'occasion_id')
            ->select('id', 'name', 'logo', 'active');
    }

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class, 'id', 'service_type_id')
            ->select('id', 'name', 'active');
    }


}

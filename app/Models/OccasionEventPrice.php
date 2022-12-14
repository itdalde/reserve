<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionEventPrice extends Model
{
    use HasFactory;

    public function planType()
    {
        return $this->hasOne(PlanType::class,'id','plan_id');
    }
}

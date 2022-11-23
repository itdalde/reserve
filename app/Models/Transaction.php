<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function occasionEvent() {
        return $this->belongsTo(OccasionEvent::class,'occasion_event_id','id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function status() {
        return $this->hasOne(Status::class);
    }
    public function plan() {
        return $this->hasOne(PlanType::class);
    }
}

<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionEventReviews extends Model
{
    use HasFactory;
    protected $table = 'services_reviews';

    public function occasionEvent() {
        return $this->belongsTo(OccasionEvent::class,'occasion_event_id','id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}

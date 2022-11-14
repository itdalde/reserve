<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    use HasFactory;
    public function occasionEvent()
    {
        return $this->belongsTo(OccasionEvent::class, 'occasion_event_id');
    }
}

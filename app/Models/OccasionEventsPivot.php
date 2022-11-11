<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionEventsPivot extends Model
{
    use HasFactory;

    public function occasion()
    {
        return $this->belongsTo(Occasion::class,'occasion_id','id');
    }
}

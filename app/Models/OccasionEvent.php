<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionEvent extends Model
{
    use HasFactory;

    public function occasion() {
        return $this->belongsTo(Occasion::class);
    }
}

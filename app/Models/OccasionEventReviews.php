<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionEventReviews extends Model
{
    use HasFactory;

    public function occasion() {
        return $this->belongsTo(Occasion::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}

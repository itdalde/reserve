<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $column = ['id'];

    use SoftDeletes;

    public function service()
    {
        return $this->hasOne(OccasionEvent::class, 'id', 'service_id')->with('company', 'serviceRate', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery');
    }

}

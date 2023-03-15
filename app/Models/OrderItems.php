<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(OccasionEvent::class, 'id', 'service_id')->with('providers','gallery');
    }
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}

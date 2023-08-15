<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdOns extends Model
{
    use HasFactory;

    protected $table = 'order_add_ons';

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
    public function orderItem()
    {
        return $this->hasOne(OrderItems::class, 'id', 'order_item_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAdOns extends Model
{
    use HasFactory;

    protected $table = 'cart_add_ons';

    public function order()
    {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }
    public function orderItem()
    {
        return $this->hasOne(CartItem::class, 'id', 'cart_item_id');
    }

}

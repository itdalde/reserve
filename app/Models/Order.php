<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function items() {
        return $this->hasMany(OrderItems::class)->with('service');
    }

    public function paymentMethod() {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method')
        ->select('id', 'card_type', 'name', 'expiry_date', 'last_four_digit', 'cvv', 'is_active');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSplit extends Model
{
    use HasFactory;

    protected $table = 'order_split';

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id')->with('user');
    }
}

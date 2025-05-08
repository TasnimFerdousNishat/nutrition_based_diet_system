<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = ['customer_id','customer_name', 'customer_phone', 'payment_method', 'total_price','status','is_delivered'];

public function orderItems() {
    return $this->hasMany(OrderItem::class);
}

}

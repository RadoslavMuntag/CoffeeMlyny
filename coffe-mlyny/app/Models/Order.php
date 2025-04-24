<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'coupon_id',
        'address',
        'payment_method_id',
        'shipping_method_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'city',
        'postal_code',
    ];
}

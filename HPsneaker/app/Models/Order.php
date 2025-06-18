<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'total_amount', 'voucher_id', 'discount_applied',
        'status', 'payment_method', 'shipping_address'
    ];

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'order_id', 'id');
    }
}

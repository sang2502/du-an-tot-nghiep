<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'total_amount',
        'voucher_id',
        'discount_applied',
        'status',
        'payment_method',
        'shipping_address'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }
}

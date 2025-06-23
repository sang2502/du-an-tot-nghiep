<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Khớp hoàn toàn với migration mới!
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

    // Quan hệ với order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với voucher (nếu có)
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

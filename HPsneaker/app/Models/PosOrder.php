<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;
    protected $table = 'pos_orders';
    protected $fillable = [
        'staff_id', 'customer_id', 'voucher_id', 'discount_applied',
        'total_amount', 'payment_method', 'note'
    ];
}

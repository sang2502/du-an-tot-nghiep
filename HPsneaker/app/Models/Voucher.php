<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'description', 'discount_type', 'discount_value',
        'max_discount', 'min_order_value', 'usage_limit', 'used_count',
        'valid_from', 'valid_to'
    ];
}

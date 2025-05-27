<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderItem extends Model
{
    use HasFactory;
    protected $table = 'pos_order_items';
    protected $fillable = ['pos_order_id', 'product_variant_id', 'quantity', 'price'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;



    protected $fillable = [
        'order_id', 'product_variant_id', 'quantity', 'price'
    ];

    // Quan hệ về Order
    protected $table = 'order_items';
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function variant() {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

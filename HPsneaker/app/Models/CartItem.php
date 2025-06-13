<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'product_variant_id', 'quantity'];

    public function variant() {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    public function product() {
        return $this->belongsTo(Product::class, 'product_variant_id', 'id');
    }
}

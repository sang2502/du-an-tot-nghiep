<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'category_id', 'price', 'thumbnail', 'status'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

      public function comments()
    {
    return $this->hasMany(Comment::class);
    }

    public function reviews()
    {
    return $this->hasMany(\App\Models\Review::class);
    }

}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'user_id', 'name', 'email', 'cmt', 'status'];
    public function user()
{
    return $this->belongsTo(User::class);
}
public function review()
{
    return $this->hasOne(Review::class, 'user_id', 'user_id')
                ->where('product_id', $this->product_id);
}
}

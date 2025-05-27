<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function blogPostTags() {
    return $this->hasMany(BlogPostTag::class);
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Post;

class CategoryPost extends Model
{
    use HasFactory;

    /**
     * Get the category that the category post belongs
     * 
     **/
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the post that the category post belongs
     * 
     **/
    public function post() {
        return $this->belongsTo(Post::class);
    }
}

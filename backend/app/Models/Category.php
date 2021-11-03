<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryPost;

class Category extends Model
{
    use HasFactory;

    /**
     * Get the list of category posts
     * 
     **/
    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Like extends Model
{
    use HasFactory;

    /**
     * Get the user that the like belongs
     * 
     **/
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that the like belongs
     * 
     **/
    public function post() {
        return $this->belongsTo(Post::class);
    }

    /**
     * Check if the post is already liked
     * 
     * @return bool
     **/
    public static function isLiked($userId, $postId)
    {
        return Like::where('user_id', $userId)->where('post_id', $postId)->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Follow extends Model
{
    use HasFactory;

    /**
     * Get the user that is followed
     * 
     **/
    public function followed()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that is following
     * 
     **/
    public function following()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if user is already followed
     * 
     * @return bool
     **/
    public static function isFollowed($userId, $followedId)
    {
        return Follow::where('followed_id', $userId)->where('following_id', $followedId)->exists();
    }
}

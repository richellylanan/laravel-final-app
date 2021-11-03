<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\CategoryPost;
use App\Models\Comment;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    const S3_IMAGES_FOLDER  = 'images/';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'description',
        'image',
    ];

    /**
     * Get the user that the post belongs
     * 
     **/
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the list of category posts of the post
     * 
     **/
    public function categoryPost() {
        return $this->hasMany(CategoryPost::class);
    }

    /**
     * Get the list of comments of the post
     * 
     **/
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes of the post
     * 
     **/
    public function likes() {
        return $this->hasMany(Like::class);
    }

    /**
     * Show image that is fetched from the local / S3 server
     *
     * @param String $image
     * @return String
     */
    public static function showImage($image)
    {
        return config('app.env') === 'local'
                ? asset('/storage/images/' . $image) 
                : Storage::disk('s3')->temporaryUrl(
                    self::S3_IMAGES_FOLDER . $image,
                    now()->addMinutes(10)
                );
    }
}

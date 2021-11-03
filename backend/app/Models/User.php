<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\Like;
use App\Models\Post;
use App\Models\Follow;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    const S3_AVATAR_FOLDER  = 'avatars/';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the likes of the user
     * 
     **/
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the posts of the user
     * 
     **/
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * Get user followers
     */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id', 'id');
    }

    /**
     * Get user following
     */
    public function following()
    {
        return $this->belongsTo(Follow::class, 'id', 'followed_id');
    }

    /**
     * Show suggested users to follow
     * 
     * @return Collection
     **/
    public function getSuggestedUsers($authId)
    {
        return User::select([
                    'users.id',
                    'users.avatar',
                    'users.name'
                ])
                ->whereNotIn('users.id', function($query) use ($authId) {
                    $query->from('follows')
                        ->select(['follows.following_id'])
                        ->where('followed_id', $authId);
                })
                ->where('users.role_id', self::USER_ROLE_ID)
                ->where('users.id', '!=', $authId)
                ->get();
    }

    /**
     * Show avatar that is fetched from the local / S3 server
     *
     * @param String $image
     * @return String
     */
    public static function showAvatar($image)
    {
        return config('app.env') === 'local'
                ? asset('/storage/avatars/' . $image) 
                : Storage::disk('s3')->temporaryUrl(
                    self::S3_AVATAR_FOLDER . $image,
                    now()->addMinutes(10)
                );
    }
}

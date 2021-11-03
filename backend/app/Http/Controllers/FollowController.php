<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    /**
     * The Follow model instance.
     */
    private $follow;

    /**
     * Profile Controller instance.
     *
     * @param  \App\Models\User  $user
     * 
     * @return void
     */
    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    /**
     * Store the new given follow resource.
     *
     * @param  Int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function store($id) 
    {
        $follow                 = new Follow;
        $follow->followed_id    = Auth::user()->id;
        $follow->following_id   = $id;
        $follow->save();

        return redirect()->back();
    }

    /**
     * follow resource.
     *
     * @param  Int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function destroy($id)
    {
        $this->follow->where('followed_id', Auth::user()->id)->where('following_id', $id)->delete();

        return redirect()->back();
    }
}

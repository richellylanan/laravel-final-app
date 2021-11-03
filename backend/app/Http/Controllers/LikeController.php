<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * The Like model instance.
     */
    private $like;

    /**
     * Like Controller instance.
     *
     * @param  \App\Models\Like  $like
     * 
     * @return void
     */
    public function __construct(Like $like)
    {
    	$this->like = $like;
    }

    /**
     * Store the new given comment resource.
     *
     * @param  int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function store($id)
    {
    	$like = new Like;
        $like->user_id 	= Auth::user()->id;
        $like->post_id 	= $id;
        $like->save();

        return redirect()->back();
    }

    /**
     * Destroy the like resource.
     *
     * @param int  $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function destroy($id)
    {
    	$this->like->where('user_id', Auth::user()->id)->where('post_id', $id)->delete();

        return redirect()->back();
    }
}

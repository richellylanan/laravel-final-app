<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * The Post model instance.
     */
    private $post;

    /**
     * The User model instance.
     */
    private $user;

    /**
     * Home constructor.
     *
     * @param Post $post
     * @param User $user
     * 
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search         = $request->input('search') ?? null;
        $suggestedUsers = $this->user->getSuggestedUsers(Auth::user()->id);
        $model          = $this->post->select('posts.*');

        if ($search) {
            $model->where('description', 'like', '%' . $search . '%');
        }

        $posts = $model->latest()->get();

        return view('users.home')
                ->with('posts', $posts)
                ->with('search', $search)
                ->with('suggestedUsers', $suggestedUsers);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostsController extends Controller
{
    const PER_PAGE = 10;

    /**
     * The Post model instance.
     */
    private $post;

    /**
     * Post Controller instance.
     *
     * @param  \App\Models\Post  $post
     * 
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Show index application
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->post->with(['user' => function($query) {
            return $query->withTrashed();
        }])->withTrashed()->latest()->paginate(self::PER_PAGE);

        return view('admin.posts.index')->with('posts', $posts);
    }

    /**
     * Activate trashed post
     * 
     * @param int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function activate($id)
    {
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    /**
     * Deactivate active post
     * 
     * @param int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function deactivate($id)
    {
        $this->post->findOrFail($id)->delete();

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * The Comment model instance.
     */
    private $comment;

    /**
     * Comment Controller instance.
     *
     * @param  \App\Models\Comment  $comment
     * 
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Store the new given comment resource.
     *
     * @param Integer $id
     * @param  Request $request
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function store($id, Request $request)
    {
        $request->validate([
            'comment_body' . $id => 'required|max:150',
        ],
        [
            'comment_body' . $id . '.required' => 'The comment field is required.',
            'comment_body' . $id . '.max' => 'The comment must not be greater than 150 characters.'   
        ]);

        $comment            = new Comment;
        $comment->user_id   = Auth::user()->id;
        $comment->post_id   = $id;
        $comment->body      = $request->input('comment_body'. $id);
        $comment->save();

        return redirect()->back();
    }
}

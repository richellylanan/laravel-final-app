<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    const PER_PAGE = 10;

    /**
     * The User model instance.
     */
    private $user;

    /**
     * Users Controller instance.
     *
     * @param  \App\Models\User  $user
     * 
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Show the application users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = $this->user->withTrashed()->latest()->paginate(self::PER_PAGE);

        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Activate trashed user
     * 
     * @param int $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function activate($id)
    {
        $this->user->onlyTrashed()->findOrFail($id)->restore();

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
        $this->user->findOrFail($id)->delete();

        return redirect()->back();
    }
}

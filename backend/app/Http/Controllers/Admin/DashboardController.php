<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    const PER_PAGE = 10;

    /**
     * The User model instance.
     */
    private $user;

    /**
     * Dashboard Controller instance.
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
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->latest()->paginate(self::PER_PAGE);

        return view('admin.home')->with('users', $users);
    }
}

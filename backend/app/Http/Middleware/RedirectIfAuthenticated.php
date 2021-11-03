<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(
            Auth::guard($guards)->check() && 
            (Auth::user()->role_id == User::ADMIN_ROLE_ID || Auth::user()->role_id == User::USER_ROLE_ID)
        ) {
            return redirect()->route('index');
        }
        return $next($request);
    }
}

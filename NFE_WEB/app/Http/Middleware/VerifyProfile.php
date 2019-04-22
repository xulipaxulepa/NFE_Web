<?php

namespace App\Http\Middleware;

use App\Model\Profile;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifyProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $profile = Profile::where('user', Auth::id())->first();
        if (!is_null($profile) && !Session::has('profile')) {
            Session::put('profile', $profile);
        }
        return $next($request);
    }
}

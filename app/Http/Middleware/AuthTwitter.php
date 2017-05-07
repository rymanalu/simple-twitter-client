<?php

namespace App\Http\Middleware;

use Closure;

class AuthTwitter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('access_token')) {
            return $next($request);
        }

        return redirect()->route('auth::error')->with('message', 'please login');
    }
}

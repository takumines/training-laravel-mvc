<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserStatusCheck
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
        if (auth::check() && auth::user()->status == 'suspension') {
            return redirect('/login')->with('flash_message', '利用制限中でログインできませんでした');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RequireAdmin {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(\Auth::user() === null)
            return redirect()->route('login');
        if(\Auth::user()->type !== User::TYPE_ADMIN)
            return redirect('/');
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RequireTeacher {
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
        if(\Auth::user()->type !== User::TYPE_TEACHER || \Auth::user()->teacher === null) {
            if(\Auth::user()->type === User::TYPE_ADMIN) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/');
        }
        return $next($request);
    }
}

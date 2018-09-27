<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->teacher !== null)
                return redirect()->route('teacher.classes');
            if(Auth::user()->type === User::TYPE_ADMIN) {
                \Log::info('Admin logged in: ' . \Auth::user()->toJson() . ' from ip ' . Request::capture()->ip());
                return redirect()->route('admin.classes');
            }
            return redirect('/');
        }

        return $next($request);
    }
}

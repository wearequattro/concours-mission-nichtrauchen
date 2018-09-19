<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login/redirect';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginRedirect() {
        if(\Auth::user() !== null) {
            if(\Auth::user()->type === User::TYPE_TEACHER && \Auth::user()->teacher !== null) {
                return redirect()->route('teacher.classes');
            } else if(\Auth::user()->type === User::TYPE_ADMIN) {
                return redirect()->route('admin.classes');
            }
        }
        return redirect()->route('login');
    }

    protected function loggedOut(Request $request) {
        return redirect()->route('login');
    }
}

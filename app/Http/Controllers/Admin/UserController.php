<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function users() {
        return view('admin.users')->with([
            'users' => User::query()->where('type', User::TYPE_ADMIN)->get(),
        ]);
    }

}

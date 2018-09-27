<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserCreateRequest;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller {

    public function users() {
        return view('admin.users')->with([
            'users' => User::query()->where('type', User::TYPE_ADMIN)->get(),
        ]);
    }

    public function usersAdd() {
        return view('admin.users-add');
    }

    public function usersAddPost(AdminUserCreateRequest $request) {
        $data = $request->validated();
        User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => User::TYPE_ADMIN,
        ]);
        \Log::info(\Auth::user()->email . ' created a new admin: ' . $data['email']);
        Session::flash('message', 'Utilisateur ajouté avec succès');
        return redirect()->route('admin.users');
    }

}

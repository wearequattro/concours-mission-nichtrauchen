<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function classes() {
        return view('admin.dashboard');
    }

    public function schools() {
        return view('admin.schools')->with([
            'schools' => School::all(),
        ]);
    }

    public function documents() {
        return view('admin.dashboard');
    }

    public function teachers() {
        return view('admin.dashboard');
    }

    public function emails() {
        return view('admin.dashboard');
    }

    public function party() {
        return view('admin.dashboard');
    }

}

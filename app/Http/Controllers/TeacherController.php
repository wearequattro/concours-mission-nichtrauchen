<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller {

    public function profile() {
        return view('register-teacher.profile');
    }

    public function profilePost(Request $request) {
        return redirect()->route('teacher.profile');
    }

}

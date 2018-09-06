<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class TeacherRegisterController extends Controller {

    function start() {
        return view('register-teacher.start');
    }

    function startPost(Request $request) {
        return redirect()->route('teacher-register.classes');
    }

    function classes() {
        return view('register-teacher.classes-list');
    }

    function classesAdd() {
        return view('register-teacher.classes-add')->with([
            'schools' => School::all(),
        ]);
    }

    function classesAddPost(Request $request) {
        return redirect()->route('teacher-register.classes');
    }

}

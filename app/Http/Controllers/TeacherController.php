<?php

namespace App\Http\Controllers;

use App\School;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller {

    public function profile() {
        return view('register-teacher.profile');
    }

    public function profilePost(Request $request) {
        return redirect()->route('teacher.profile');
    }

    function classes() {
        return view('register-teacher.classes-list')->with([
            'inscription_date_end' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->format('d M'),
            'inscription_date_end_relative' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->diffForHumans(),
        ]);
    }

    function classesAdd() {
        return view('register-teacher.classes-add')->with([
            'schools' => School::all(),
        ]);
    }

    function classesAddPost(Request $request) {
        return redirect()->route('teacher-register.classes');
    }

    function documents() {
        return view('register-teacher.documents');
    }

    function party() {

    }

}

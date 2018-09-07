<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRegisterRequest;
use App\Salutation;
use App\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherRegisterController extends Controller {

    function start() {
        return view('register-teacher.start')->with([
            'salutations' => Salutation::all(),
        ]);
    }

    function startPost(TeacherRegisterRequest $request) {
        $data = $request->validated();
        $teacher = Teacher::createWithUser(
            $data['teacher_salutation'],
            $data['teacher_name'],
            $data['teacher_surname'],
            $data['teacher_email'],
            $data['teacher_password'],
            $data['teacher_phone']);
        Auth::login($teacher->user);
        return redirect()->route('teacher-register.classes');
    }

}

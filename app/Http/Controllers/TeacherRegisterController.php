<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRegisterRequest;
use App\Salutation;
use Illuminate\Http\Request;

class TeacherRegisterController extends Controller {

    function start() {
        return view('register-teacher.start')->with([
            'salutations' => Salutation::all(),
        ]);
    }

    function startPost(TeacherRegisterRequest $request) {
        $data = $request->validated();
        dd($data);
        return redirect()->route('teacher-register.classes');
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolClassCreateRequest;
use App\School;
use App\SchoolClass;
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
            'inscription_date_end' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->format('d M Y'),
            'inscription_date_end_relative' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->diffForHumans(),
            'classes' => SchoolClass::findForLoggedInUser(),
        ]);
    }

    function classesAdd() {
        return view('register-teacher.classes-add')->with([
            'schools' => School::all(),
        ]);
    }

    function classesAddPost(SchoolClassCreateRequest $request) {
        $data = $request->validated();
        $teacher = \Auth::user()->teacher;
        $school = School::findOrFail($request['class_school']);
        SchoolClass::createForTeacher($teacher, $data['class_name'], $data['class_students'], $school);
        return redirect()->route('teacher-register.classes');
    }

    function documents() {
        return view('register-teacher.documents');
    }

    function party() {

    }

}

<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SchoolClassCreateRequest;
use App\Salutation;
use App\School;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller {

    public function profile() {
        return view('teacher.profile')->with([
            'user' => \Auth::user(),
            'teacher' => \Auth::user()->teacher,
            'salutations' => Salutation::all(),
        ]);
    }

    public function profilePost(ProfileUpdateRequest $request) {
        $data = $request->validated();
        \Auth::user()->teacher->update([
            'first_name' => $data['teacher_first_name'],
            'last_name' => $data['teacher_last_name'],
            'phone' => $data['teacher_phone'],
            'salutation_id' => $data['teacher_salutation'],
        ]);
        \Auth::user()->update([
            'email' => $data['teacher_email'],
        ]);
        if(isset($data['teacher_password']) && $data['teacher_password'] !== null)
            \Auth::user()->updatePassword($data['teacher_password']);

        \Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('teacher.profile');
    }

    function classes() {
        return view('teacher.classes-list')->with([
            'inscription_date_end' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->format('d M Y'),
            'inscription_date_end_relative' => Carbon::parse(env('TEACHER_INSCRIPTION_END'))->diffForHumans(),
            'classes' => SchoolClass::findForLoggedInUser(),
        ]);
    }

    function classesAdd() {
        return view('teacher.classes-add')->with([
            'schools' => School::all(),
        ]);
    }

    function classesAddPost(SchoolClassCreateRequest $request) {
        $data = $request->validated();
        $teacher = \Auth::user()->teacher;
        $school = School::findOrFail($request['class_school']);
        SchoolClass::createForTeacher($teacher, $data['class_name'], $data['class_students'], $school);
        return redirect()->route('teacher.classes');
    }

    function documents() {
        return view('teacher.documents')->with([
            'documents' => Document::all(),
        ]);
    }

    function party() {

    }

}

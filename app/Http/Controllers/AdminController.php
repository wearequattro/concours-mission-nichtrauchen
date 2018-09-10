<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminClassUpdateRequest;
use App\Http\Requests\AdminSchoolUpdateRequest;
use App\School;
use App\SchoolClass;
use App\Teacher;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller {

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function classes() {
        return view('admin.classes')->with([
            'classes' => SchoolClass::all(),
        ]);
    }

    public function classesEdit(SchoolClass $class) {
        return view('admin.classes-edit')->with([
            'class' => $class,
            'schools' => School::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function classesEditPost(AdminClassUpdateRequest $request, SchoolClass $class) {
        $class->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.classes');
    }

    public function schools() {
        return view('admin.schools')->with([
            'schools' => School::all(),
        ]);
    }

    public function schoolsEdit(School $school) {
        return view('admin.schools-edit')->with([
            'school' => $school,
        ]);
    }

    public function schoolsEditPost(AdminSchoolUpdateRequest $request, School $school) {
        $data = $request->validated();
        $school->update([
            'name' => $data['school_name'],
            'address' => $data['school_address'],
            'postal_code' => $data['school_postal_code'],
            'city' => $data['school_city'],
        ]);
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.schools');
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

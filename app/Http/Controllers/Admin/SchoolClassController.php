<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminClassUpdateRequest;
use App\School;
use App\SchoolClass;
use App\Teacher;
use Illuminate\Support\Facades\Session;

class SchoolClassController {

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

}
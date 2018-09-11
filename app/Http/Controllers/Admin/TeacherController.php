<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminTeacherUpdateRequest;
use App\Salutation;
use App\Teacher;
use Illuminate\Support\Facades\Session;

class TeacherController {

    public function teachers() {
        return view('admin.teachers')->with([
            'teachers' => Teacher::all(),
        ]);
    }

    public function teachersEdit(Teacher $teacher) {
        return view('admin.teachers-edit')->with([
            'teacher' => $teacher,
            'salutations' => Salutation::all(),
        ]);
    }

    public function teachersEditPost(AdminTeacherUpdateRequest $request, Teacher $teacher) {
        $teacher->update($request->validated());
        $teacher->user->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.teachers');
    }

}
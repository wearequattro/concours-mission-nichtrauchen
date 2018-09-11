<?php

namespace App\Http\Controllers;

use App\Document;
use App\EditableEmail;
use App\Http\Requests\AdminClassUpdateRequest;
use App\Http\Requests\AdminDocumentUploadRequest;
use App\Http\Requests\AdminEmailsUpdateRequest;
use App\Http\Requests\AdminSchoolUpdateRequest;
use App\Http\Requests\AdminTeacherUpdateRequest;
use App\PartyGroup;
use App\PlaceHolder;
use App\Salutation;
use App\School;
use App\SchoolClass;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;
use Ramsey\Uuid\Uuid;
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
        return view('admin.documents')->with([
            'documents' => Document::all(),
        ]);
    }

    public function documentsPost(AdminDocumentUploadRequest $request) {
        $data = $request->validated();
        $name = \Storage::putFile("documents", $request->file('file'));

        Document::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'filename' => $name,
        ]);
        return redirect()->route('admin.documents');
    }

    public function documentsToggleVisibility(Document $document) {
        $document->update([
            'visible' => !$document->visible
        ]);
        return redirect()->route('admin.documents');
    }

    public function documentsDownload(Document $document) {
        return Storage::download($document->filename);
    }

    public function documentsDelete(Document $document) {
        Storage::delete($document->filename);
        $document->delete();
        return redirect()->route('admin.documents');
    }

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

    public function emails() {
        return view('admin.emails')->with([
            'emails' => EditableEmail::all(),
        ]);
    }

    public function emailsEdit(EditableEmail $email) {
        $placeholders = EditableEmail::getPlaceholders()
            ->map(function (PlaceHolder $placeHolder) {
                return ['text' => $placeHolder->previewValue, 'value' => $placeHolder->key];
            });
        return view('admin.emails-edit')->with([
            'email' => $email,
            'placeholders' => $placeholders,
        ]);
    }

    public function emailsEditPost(AdminEmailsUpdateRequest $request, EditableEmail $email) {
        $email->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.emails');
    }

    public function party() {
        $groups = PartyGroup::all()->groupBy('school_class_id');

        return view('admin.party')->with([
            'groups' => $groups,
        ]);
    }

}

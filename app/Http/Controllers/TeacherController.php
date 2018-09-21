<?php

namespace App\Http\Controllers;

use App\Document;
use App\EditableDate;
use App\EditableEmail;
use App\Http\Requests\PartyGroupRegistrationRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SchoolClassCreateRequest;
use App\Mail\CustomEmail;
use App\PartyGroup;
use App\Salutation;
use App\School;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
        \Auth::user()->teacher->update($data);
        \Auth::user()->update([
            'email' => $data['email'],
        ]);
        if (isset($data['password']) && $data['password'] !== null)
            \Auth::user()->updatePassword($data['password']);

        \Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('teacher.profile');
    }

    function classes() {
        return view('teacher.classes-list')->with([
            'inscription_date_end' => EditableDate::find(EditableDate::TEACHER_INSCRIPTION_END)->format('d M Y'),
            'inscription_date_end_relative' => EditableDate::find(EditableDate::TEACHER_INSCRIPTION_END)->diffForHumans(),
            'classes' => SchoolClass::findForLoggedInUser(),
            'show_january' => Carbon::now()->gte(EditableDate::find(EditableDate::FOLLOW_UP_1)),
            'show_march' => Carbon::now()->gte(EditableDate::find(EditableDate::FOLLOW_UP_2)),
            'show_may' => Carbon::now()->gte(EditableDate::find(EditableDate::FOLLOW_UP_3)),
            'show_party' => Carbon::now()->gte(EditableDate::find(EditableDate::FOLLOW_UP_3)),
        ]);
    }

    function classesAdd() {
        if(!isRegistrationOpen()) {
            return redirect()->route('teacher.classes');
        }
        return view('teacher.classes-add')->with([
            'schools' => School::all(),
        ]);
    }

    function classesAddPost(SchoolClassCreateRequest $request) {
        if(!isRegistrationOpen()) {
            return redirect()->route('teacher.classes');
        }
        $data = $request->validated();
        $teacher = \Auth::user()->teacher;
        $school = School::findOrFail($request['class_school']);
        SchoolClass::createForTeacher($teacher, $data['class_name'], $data['class_students'], $school);
        return redirect()->route('teacher.classes');
    }

    function documents() {
        return view('teacher.documents')->with([
            'documents' => Document::query()->where('visible', 1)->get(),
        ]);
    }

    function documentsDownload(Document $document) {
        if($document->visible == true ||
            $document->visible_party == true &&
            \Auth::user()->teacher != null &&
            \Auth::user()->teacher->hasAccessToParty()) {
            $exploded = explode('.', $document->filename);
            return Storage::download($document->filename, preg_replace('/[^a-z0-9]+/', '-', strtolower($document->title))
                . '.' . $exploded[count($exploded) - 1]);
        }
        return redirect()->route('teacher.documents');
    }

    function party() {
        if(!\Auth::user()->hasAccessToParty())
            return redirect()->route('teacher.classes');
        $classes = SchoolClass::findForLoggedInUser()->sort(function (SchoolClass $schoolClass) {
            return $schoolClass->partyGroups()->exists() ? 1 : 0;
        });
        return view('teacher.party')->with([
            'classes' => $classes,
            'documents' => Document::query()->where('visible_party', 1)->get(),
        ]);
    }

    function partyClass(SchoolClass $class) {
        if(!\Auth::user()->hasAccessToParty())
            return redirect()->route('teacher.classes');
        if($class->partyGroups()->exists())
            return redirect()->route('teacher.party');
        return view('teacher.party-class')->with([
            'class' => $class,
            'groups' => $class->mapToGroups(),
        ]);
    }

    function partyClassPost(PartyGroupRegistrationRequest $request, SchoolClass $class) {
        if(!\Auth::user()->hasAccessToParty())
            return redirect()->route('teacher.classes');
        $data = $request->validated()['class'];
        if (collect($data)->sum('students') > $class->students) {
            $errors = [];
            for ($i = 0; $i < sizeof($data); $i++) {
                $errors['class.'.$i.'.students'] = ['La somme des étudiants des groupes doit être inférieur au nombre d\'étudiants de la classe'];
            }
            throw ValidationException::withMessages($errors);
        }
        for ($i = 0; $i < sizeof($data); $i++) {
            $name = $data[$i]['name'];
            $language = $data[$i]['language'];
            $students = $data[$i]['students'];
            PartyGroup::create([
                'name' => $name,
                'students' => $students,
                'language' => $language,
                'school_class_id' => $class->id,
            ]);
        }
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail(EditableEmail::find(EditableEmail::$MAIL_PARTY_CONFIRMATION), $class->teacher, $class));
        return redirect()->route('teacher.party');
    }

}

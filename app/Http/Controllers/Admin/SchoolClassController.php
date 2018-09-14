<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminClassUpdateRequest;
use App\School;
use App\SchoolClass;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class SchoolClassController {

    public function classes() {
        return view('admin.classes')->with([
            'classes' => SchoolClass::all(),
            'show_january' => Carbon::now()->gte(Carbon::parse(env('FOLLOW_UP_1'))),
            'show_march' => Carbon::now()->gte(Carbon::parse(env('FOLLOW_UP_2'))),
            'show_may' => Carbon::now()->gte(Carbon::parse(env('FOLLOW_UP_3'))),
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

    public function resend($status) {
        $numSent = SchoolClass::all()
            ->map(function (SchoolClass $class) use ($status) {
                if ($class->shouldSendFollowUpReminder($status, false)) {
                    $class->sendFollowUpReminderEmail($status);
                    return 1;
                }
                return 0;
            })
            ->sum();
        Session::flash('message', 'Envoyé ' . $numSent . ' Emails');
        return redirect()->route('admin.classes');
    }

}
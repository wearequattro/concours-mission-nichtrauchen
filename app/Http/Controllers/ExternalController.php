<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\SchoolClass;
use Illuminate\Http\Request;

class ExternalController extends Controller {

    public function classes() {
        $classes = SchoolClass::all()->sort(function (SchoolClass $class, SchoolClass $class2) {
            return $class2->getQuizScore() <=> $class->getQuizScore()
                    ?: $class->school->name <=> $class2->school->name
                    ?: $class->teacher->last_name <=> $class2->teacher->last_name;
        });
        $totalMaxScore = Quiz::totalMaxScore();
        return view('external.classes', compact('classes', 'totalMaxScore'));
    }

}

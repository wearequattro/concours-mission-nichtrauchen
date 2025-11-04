<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Quiz;

class QuizIndexController extends Controller
{
    public function __invoke()
    {
        // $quizzes = auth()->user()->teacher->classes()->with('quizAssignments.quiz')->get();
        $quizzes = Quiz::query()
            ->with(['assignments' => function ($query) {
                return $query->whereHas('schoolClass', function ($query) {
                    $query->whereIn('id', auth()->user()->teacher->classes->pluck('id'));
                });
            }, 'assignments.schoolClass'])
            ->get();

        // $qa = $quizzes->pluck('quizAssignments')[0][0];

        // $assignments = [];
        // foreach ($quizzes as $key => $class) {
        //     $assignments[] = $class->quizAssignments;
        // }

        // return $assignments;

        // return route('external.quiz.show', [$qa->uuid]);

        return view('teacher.quizzes', compact('quizzes'));
    }
}
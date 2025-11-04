<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Quiz;

class QuizIndexController extends Controller
{
    public function __invoke()
    {
        $quizzes = Quiz::query()
            ->with(['assignments' => function ($query) {
                return $query->whereHas('schoolClass', function ($query) {
                    $query->whereIn('id', auth()->user()->teacher->classes->pluck('id'));
                });
            }, 'assignments.schoolClass', 'assignments.codes', 'assignments.response'])
            ->where('state', '!=', Quiz::STATE_NEW)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.quizzes', compact('quizzes'));
    }
}
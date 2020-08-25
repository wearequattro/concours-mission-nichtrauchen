<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizAssignment;
use App\QuizCode;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function showQuizRedirect(string $uuid) {
        /** @var QuizAssignment $assignment */
        $assignment = QuizAssignment::where('uuid', $uuid)->firstOrFail();

        $quiz = $assignment->quiz;
        $codes = $assignment->codes;
        return view('external.quiz-redirect', compact('codes', 'quiz', 'assignment'));
    }

    public function redirect(QuizCode $quizCode) {
        abort_if($quizCode->assignment->isAnswered(), 403, 'Vous avez déjà répondu');
        abort_if($quizCode->assignment->quiz->state === Quiz::STATE_CLOSED, 403, 'Le quiz est clôturé');
        return response()->redirectTo($quizCode->quiz_maker_url);
    }
}

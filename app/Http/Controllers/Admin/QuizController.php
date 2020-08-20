<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Quiz;
use App\SchoolClass;
use Illuminate\Http\Request;

class QuizController extends Controller {

    public function index() {
        $quizzes = Quiz::all();
        return view('admin.quiz', compact('quizzes'));
    }

    public function create() {
        $classes = SchoolClass::all();
        $quiz = new Quiz();
        $languages = ['FR', 'DE'];

        return view('admin.quiz-create', compact('classes', 'quiz'));
    }

    public function createPost(Request  $request) {
        dd($request->all());

    }



}

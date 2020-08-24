<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Quiz;
use App\QuizInLanguage;
use App\Rules\QuizMakerValidUrlRule;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;

class QuizController extends Controller {

    private $languages = ['fr', 'de'];

    public function index() {
        $quizzes = Quiz::all();
        return view('admin.quiz', compact('quizzes'));
    }

    public function create() {
        $classes = SchoolClass::all();
        $quiz = new Quiz();

        return view('admin.quiz-create', compact('classes', 'quiz'), ['languages' => $this->languages]);
    }

    public function createPost(Request $request) {
        $rules = [
            'name' => 'required|string',
            'max_score' => 'required|int|min:1',
            'closes_at' => 'required|date|after:today',
            'classes' => 'array',
            'classes.*' => 'int|exists:school_classes,id',
            'email_text' => 'string|nullable',
        ];

        foreach ($this->languages as $lang) {
            $rules["quiz_url.$lang"] = ['required', 'url', new QuizMakerValidUrlRule];
        }

        $data = $this->validate($request, $rules);

        $data['closes_at'] = Carbon::createFromTimestamp(strtotime($data['closes_at']));
        $data['email_text'] = $data['email_text'] ?? "";
        $quiz = Quiz::create($data);

        foreach ($data['quiz_url'] as $lang => $url) {
            /** @var QuizInLanguage $quizInLanguage */
            $quizInLanguage = $quiz->quizInLanguage()->create([
                'language' => $lang,
                'quiz_maker_id' => QuizMakerValidUrlRule::extractIdFromUrl($url),
            ]);

            foreach ($data['classes'] as $class) {
                $quizInLanguage->assignments()->create([
                    'school_class_id' => $class,
                ]);
            }
        }
        return redirect()->route('admin.quiz.show', [$quiz]);
    }

    public function show(Quiz $quiz) {
        $responses = (new EloquentCollection(
            $quiz
                ->quizInLanguage
                ->flatMap(fn($qIL) => $qIL->responses)
            ))
            ->load('assignment.schoolClass', 'assignment.schoolClass.teacher', 'assignment.schoolClass.teacher.salutation', 'assignment.quizInLanguage');
        return view('admin.quiz-show', compact('quiz', 'responses'));
    }

}

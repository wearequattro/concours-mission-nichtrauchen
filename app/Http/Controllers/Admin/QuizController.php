<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\QuizMail;
use App\Quiz;
use App\QuizInLanguage;
use App\Rules\QuizMakerValidUrlRule;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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
            $quiz->quizInLanguage()->create([
                'language' => $lang,
                'quiz_maker_id' => QuizMakerValidUrlRule::extractIdFromUrl($url),
            ]);
        }

        foreach ($data['classes'] as $class) {
            $quiz->assignments()->create([
                'school_class_id' => $class,
            ]);
        }

        return redirect()->route('admin.quiz.show', [$quiz]);
    }

    public function edit(Quiz $quiz) {
        $classes = SchoolClass::all();
        return view('admin.quiz-create', compact('quiz', 'classes'), ['languages' => $this->languages]);
    }

    public function editPost(Request $request, Quiz $quiz) {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'max_score' => 'required|int|min:1',
            'closes_at' => 'required|date|after:today',
            'email_text' => 'string|nullable',
        ]);
        $data['closes_at'] = Carbon::createFromTimestamp(strtotime($data['closes_at']));
        $data['email_text'] = $data['email_text'] ?? "";
        $quiz->update($data);
        return redirect()->route('admin.quiz.show', [$quiz]);
    }

    public function show(Quiz $quiz) {
        return view('admin.quiz-show', compact('quiz'));
    }

    public function codes(Quiz $quiz) {
        return view('admin.quiz-codes', compact('quiz'), ['languages' => $this->languages]);
    }

    public function createCodes(Request $request, Quiz $quiz) {
        foreach ($this->languages as $lang) {
            $rules["files.$lang"] = ['required', 'file', 'mimes:txt'];
        }
        $this->validate($request, $rules);

        $assignments = $quiz->assignments()->pluck('id');

        // validate code count <=> assignment cound
        $codesForLanguage = [];
        $errors = [];
        foreach ($this->languages as $lang) {
            $content = $request->file("files.$lang")->get();
            $codesForLanguage[$lang] = collect(explode("\r\n", $content));

            $given = sizeof($codesForLanguage[$lang]);
            $required = $assignments->count();
            if($given < $required) {
                $errors["files.$lang"] = ["Ce fichier na pas assez de codes uniques. $given < $required"];
            }
        }
        if($errors) {
            return back()->withErrors($errors);
        }

        // create codes for each language
        foreach ($codesForLanguage as $lang => $codes) {
            /** @var QuizInLanguage $qIL */
            $qIL = $quiz->quizInLanguage()
                ->where('language', $lang)
                ->first();

            $codes = $codes->take($assignments->count())->toArray();
            $zip = $assignments->zip($codes);

            foreach ($zip as $code) {
                $qIL->codes()
                    ->create([
                        'quiz_assignment_id' => $code->get(0),
                        'code' => $code->get(1),
                    ]);
            }
        }

        return redirect()->route('admin.quiz.show', [$quiz]);
    }

    public function review(Quiz $quiz)
    {
        $quiz->load('assignments', 'assignments.schoolClass.school', 'assignments.schoolClass.teacher');
        return view('admin.quiz-review', compact('quiz'));
    }

    public function send(Quiz $quiz)
    {
        if(!empty($quiz->validate())) {
            abort(422);
        }

        foreach ($quiz->assignments as $a) {
            \Mail::to($a->schoolClass->teacher->user->email)->queue(
                new QuizMail($a)
            );
        }

        return redirect()->route('admin.quiz.show', [$quiz]);
    }

}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuizCode
 * @package App
 * @property int id
 * @property int quiz_assignment_id
 * @property int quiz_in_language_id
 * @property string code
 * @property string quiz_maker_url
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property QuizAssignment assignment
 * @property QuizInLanguage quizInLanguage
 *
 * @mixin \Eloquent
 */
class QuizCode extends Model {

    protected $fillable = [
        'quiz_assignment_id',
        'quiz_in_language_id',
        'code',
    ];

    protected $appends = [
        'quiz_maker_url',
    ];

    public function assignment() {
        return $this->belongsTo(QuizAssignment::class, 'quiz_assignment_id');
    }

    public function quizInLanguage() {
        return $this->belongsTo(QuizInLanguage::class);
    }

    public function getQuizMakerUrlAttribute() {
        $code = substr($this->code, 1);
        return "https://linkto.run/c/$code";
    }

}

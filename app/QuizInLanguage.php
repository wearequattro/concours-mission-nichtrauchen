<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class QuizInLanguage
 * @package App
 * @property int id
 * @property string language
 * @property int quiz_id
 * @property string quiz_maker_id
 * @property string url
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Quiz quiz
 * @property QuizAssignment assignments
 * @property QuizResponse[]|Collection responses
 *
 * @mixin \Eloquent
 */
class QuizInLanguage extends Model {

    protected $fillable = [
        'language',
        'quiz_id',
        'quiz_maker_id',
    ];

    protected $appends = [
        'url',
    ];

    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }

    public function assignments() {
        return $this->hasMany(QuizAssignment::class);
    }

    public function responses() {
        return $this->hasManyThrough(QuizResponse::class, QuizAssignment::class);
    }

    public function getUrlAttribute() {
        return "https://www.quiz-maker.com/Q$this->quiz_maker_id";
    }
}

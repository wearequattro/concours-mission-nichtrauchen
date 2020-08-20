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
 * @property int quiz_maker_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Quiz quiz
 * @property QuizAssignment codes
 * @property QuizResponse[]|Collection responses
 */
class QuizInLanguage extends Model {

    protected $fillable = [
        'language',
        'quiz_id',
        'quiz_maker_id',
    ];

    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }

    public function codes() {
        return $this->hasMany(QuizAssignment::class);
    }

    public function responses() {
        return $this->hasManyThrough(QuizResponse::class, QuizAssignment::class);
    }
}

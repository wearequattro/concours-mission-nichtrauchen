<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Quiz
 * @package App
 * @property int id
 * @property string name
 * @property string email_text
 * @property int max_score
 * @property Carbon closes_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property QuizInLanguage[]|Collection quizInLanguage
 * @property QuizAssignment[]|Collection assignments
 * @property QuizResponse[]|Collection responses
 *
 * @mixin \Eloquent
 */
class Quiz extends Model {

    protected $fillable = [
        'name',
        'email_text',
        'max_score',
        'closes_at',
    ];

    protected $dates = [
        'closes_at',
    ];

    public function quizInLanguage() {
        return $this->hasMany(QuizInLanguage::class);
    }

    public function assignments() {
        return $this->hasMany(QuizAssignment::class);
    }

    public function responses() {
        return $this->hasManyThrough(QuizResponse::class, QuizAssignment::class);
    }

}

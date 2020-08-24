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

    protected $appends = [
        'responses_count',
    ];

    public function quizInLanguage() {
        return $this->hasMany(QuizInLanguage::class);
    }

    public function getResponsesCountAttribute() {
        return $this->quizInLanguage->sum(fn($qIL) => $qIL->responses()->count());
    }

}

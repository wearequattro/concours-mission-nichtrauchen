<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @property QuizInLanguage quizInLanguage
 */
class Quiz extends Model {

    protected $fillable = [
        'name',
        'email_text',
        'max_score',
        'closes_at',
    ];

    public function quizInLanguage() {
        return $this->hasMany(QuizInLanguage::class);
    }
}

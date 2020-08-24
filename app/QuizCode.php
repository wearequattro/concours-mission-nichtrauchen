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

    public function assignment() {
        return $this->belongsTo(QuizAssignment::class, 'quiz_assignment_id');
    }

    public function quizInLanguage() {
        return $this->belongsTo(QuizInLanguage::class);
    }

}

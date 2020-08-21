<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuizCode
 * @package App
 * @property int id
 * @property int quiz_in_language_id
 * @property int school_class_id
 * @property string code
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property SchoolClass schoolClass
 * @property QuizInLanguage quizInLanguage
 *
 * @mixin \Eloquent
 */
class QuizAssignment extends Model {

    protected $fillable = [
        'quiz_in_language_id',
        'school_class_id',
        'code',
    ];

    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }

    public function quizInLanguage() {
        return $this->belongsTo(QuizInLanguage::class);
    }
}

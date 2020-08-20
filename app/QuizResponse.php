<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuizResponse
 * @package App
 * @property int id
 * @property int quiz_code_id
 * @property int score
 * @property int quizmaker_response_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property QuizAssignment code
 */
class QuizResponse extends Model {

    protected $fillable = [
        'quiz_code_id',
        'score',
        'quizmaker_response_id',
    ];

    public function code() {
        return $this->belongsTo(QuizAssignment::class);
    }
}

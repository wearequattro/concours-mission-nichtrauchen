<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class QuizCode
 * @package App
 * @property int id
 * @property int school_class_id
 * @property int quiz_id
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property SchoolClass schoolClass
 * @property QuizResponse response
 * @property Quiz quiz
 *
 * @mixin \Eloquent
 */
class QuizAssignment extends Model {

    protected $fillable = [
        'quiz_id',
        'school_class_id',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function (QuizAssignment $qa) {
            if(!$qa->uuid) {
                $qa->uuid = Uuid::uuid4()->toString();
            }
        });
    }

    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }

    public function response() {
        return $this->hasOne(QuizResponse::class);
    }

    public function codes() {
        return $this->hasMany(QuizCode::class);
    }

    public function isAnswered() {
        return $this->response()->exists();
    }

}

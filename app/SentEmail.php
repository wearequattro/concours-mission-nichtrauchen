<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SentEmail
 * @package App
 * @property int id
 * @property string editable_email_key
 * @property int user_id
 * @property User user
 * @property SchoolClass schoolClass
 * @property EditableEmail editableEmail
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static SentEmail create(array $values)
 */
class SentEmail extends Model {

    protected $fillable = ["editable_email_key", "user_id", "school_class_id"];

    public function editableEmail() {
        return $this->belongsTo(EditableEmail::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }

}

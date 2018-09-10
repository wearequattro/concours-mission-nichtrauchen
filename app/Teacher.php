<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Teacher
 * @package App
 * @property int id
 * @property int salutation_id
 * @property Salutation salutation
 * @property string first_name
 * @property string last_name
 * @property string phone
 * @property string full_name
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property User user
 *
 * @method static Teacher create(array $valueMap)
 */
class Teacher extends Model {

    protected $fillable = ['first_name', 'last_name', 'phone', 'salutation_id'];

    protected $appends = ['full_name'];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }

    public function salutation(): BelongsTo {
        return $this->belongsTo(Salutation::class);
    }

    public function getFullNameAttribute() {
        $s = $this->salutation()->first()->short_form;
        return $s . " " . $this->first_name . " " . $this->last_name;
    }

    /**
     * Creates a User and a Teacher and connects both of them together.
     * @param $salutation_id int
     * @param $firstName string
     * @param $lastName string
     * @param $email string
     * @param $password string
     * @param $phone string
     * @return Teacher The newly created teacher
     */
    public static function createWithUser($salutation_id, $firstName, $lastName, $email, $password, $phone) {
        $user = User::createUser($email, $password, User::TYPE_TEACHER);
        $teacher = Teacher::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'salutation_id' => $salutation_id
        ]);
        $teacher->user()->save($user);
        return $teacher;
    }

}

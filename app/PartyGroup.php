<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartyGroup
 * @package App
 *
 * @property int id
 * @property string name
 * @property int students
 * @property string language
 * @property int school_class_id
 * @property SchoolClass school_class
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static PartyGroup create(array $values)
 */
class PartyGroup extends Model {
    protected $fillable = ['name', 'students', 'language', 'school_class_id'];
}

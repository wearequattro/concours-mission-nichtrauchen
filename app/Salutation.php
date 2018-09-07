<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Salutation
 * @package App
 *
 * @property int id
 * @property string long_form
 * @property string short_form
 * @property Carbon updated_at
 * @property Carbon created_at
 *
 * @method static Salutation create(array $map)
 */
class Salutation extends Model {

    protected $fillable = ['long_form', 'short_form'];

}

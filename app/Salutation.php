<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Defines how to address a user in an email
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

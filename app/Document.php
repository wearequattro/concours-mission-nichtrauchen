<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Represents a document that can be downloaded by teachers.
 * @package App
 *
 * @property int id
 * @property string title
 * @property string description
 * @property string filename
 * @property boolean visible
 * @property boolean visible_party
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static Document create(array $values)
 */
class Document extends Model {

    protected $fillable = ['title', 'description', 'filename', 'visible', 'visible_party'];

}

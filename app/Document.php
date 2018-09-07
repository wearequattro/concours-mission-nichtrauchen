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
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Document extends Model {

    protected $fillable = ['title', 'description', 'filename'];

    public function getDownloadUrl() {
        if(Str::startsWith($this->filename, ['http://', 'https://']))
            return $this->filename;
        return "#";
    }

}

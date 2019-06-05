<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Certificate
 * @package App
 *
 * @property int id
 * @property int school_class_id
 * @property string url
 * @property SchoolClass schoolClass
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Certificate extends Model {

    protected $fillable = ['school_class_id', 'url'];

    /**
     * Deletes the model and its associated PDF file
     * @return bool|null
     * @throws \Exception
     */
    public function delete() {
        $this->deletePdf();
        return parent::delete();
    }

    /**
     * Deletes the PDF file, but not the model
     */
    public function deletePdf() {
        $dir = substr($this->url, 0, strrpos($this->url, '/'));
        \Storage::delete($this->url);
        \Storage::deleteDirectory($dir);
    }

}
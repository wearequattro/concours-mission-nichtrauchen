<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
 * @property int sort
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static Document create(array $values)
 */
class Document extends Model {

    protected $fillable = ['title', 'description', 'filename', 'visible', 'visible_party', 'sort'];

    public function delete() {
        static::query()->where('sort', '>', $this->sort)->update([
            'sort' => DB::raw('sort - 1')
        ]);
        return parent::delete();
    }

    public function moveUp() {
        if($this->sort == 1)
            return;
        static::query()->where('sort', $this->sort - 1)->update([
            'sort' => DB::raw('sort + 1')
        ]);
        $this->sort = $this->sort - 1;
        $this->save();
    }

    public function moveDown() {
        if($this->sort == static::query()->max('sort'))
            return;

        static::query()->where('sort', $this->sort + 1)->update([
            'sort' => DB::raw('sort - 1')
        ]);
        $this->sort = $this->sort + 1;
        $this->save();
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $filename
     * @return Document
     */
    public static function createLast(string $title, string $description, string $filename) {
        $max = static::query()->max('sort') + 1;
        return static::create([
            'filename' => $filename,
            'title' => $title,
            'description' => $description,
            'sort' => $max,
        ]);
    }


}

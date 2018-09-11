<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PartyGroup
 * @package App
 *
 * @property int id
 * @property string name
 * @property int students
 * @property string language
 * @property int school_class_id
 * @property SchoolClass schoolClass
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static PartyGroup create(array $values)
 */
class PartyGroup extends Model {
    protected $fillable = ['name', 'students', 'language', 'school_class_id'];

    public function schoolClass(): BelongsTo {
        return $this->belongsTo(SchoolClass::class);
    }
}

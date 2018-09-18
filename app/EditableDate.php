<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EditableDate
 * @package App
 *
 * @property string key
 * @property string label
 * @property Carbon value
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static EditableDate create($data)
 */
class EditableDate extends Model {

    protected $fillable = ['key', 'label', 'value'];

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $dates = ['value'];

    const TEACHER_INSCRIPTION_START = "TEACHER_INSCRIPTION_START";
    const TEACHER_INSCRIPTION_END = "TEACHER_INSCRIPTION_END";
    const NEWSLETTER_START = "NEWSLETTER_START";
    const NEWSLETTER_ENCOURAGEMENT = "NEWSLETTER_ENCOURAGEMENT";
    const FOLLOW_UP_1 = "FOLLOW_UP_1";
    const FOLLOW_UP_2 = "FOLLOW_UP_2";
    const FOLLOW_UP_3 = "FOLLOW_UP_3";
    const FINAL_MAIL = "FINAL_MAIL";

    /**
     * Finds a date value by a key. Keys are constants defined in this class.
     * @param $key
     * @return Carbon|null
     */
    public static function find($key) {
        return optional(static::query()->where('key', $key)->first())->value;
    }

    /**
     * Returns array with sub-arrays each containing default values for the fields: key, label, value
     * @return array
     */
    public static function getDefaultValues() {
        return [
            [
                'key' => static::TEACHER_INSCRIPTION_START,
                'label' => 'Début inscriptions',
                'value' => '2018-10-1',
            ],
            [
                'key' => static::TEACHER_INSCRIPTION_END,
                'label' => 'Fin inscriptions',
                'value' => '2018-10-20',
            ],
            [
                'key' => static::FOLLOW_UP_1,
                'label' => 'Suivi janvier',
                'value' => '2019-01-07',
            ],
            [
                'key' => static::FOLLOW_UP_2,
                'label' => 'Suivi mars',
                'value' => '2019-03-01',
            ],
            [
                'key' => static::FOLLOW_UP_3,
                'label' => 'Suivi mai',
                'value' => '2019-05-06',
            ],
            [
                'key' => static::FINAL_MAIL,
                'label' => 'E-mail final',
                'value' => '2019-06-07',
            ],
            [
                'key' => static::NEWSLETTER_START,
                'label' => 'Newsletter début concours',
                'value' => '2018-11-05',
            ],
            [
                'key' => static::NEWSLETTER_ENCOURAGEMENT,
                'label' => 'Newsletter encouragement',
                'value' => '2019-02-05',
            ],
        ];
    }

}

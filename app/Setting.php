<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App
 *
 * @property string key
 * @property boolean value
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @mixin \Eloquent
 */
class Setting extends Model {

    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    protected $casts = ['value' => 'boolean'];

    public static function addDefaults() {
        Setting::firstOrCreate(['key' => 'party_closed'], ['key' => 'party_closed', 'value' => false]);
    }

    public static function isPartyClosed(): bool {
        return Setting::find('party_closed')->value;
    }

}

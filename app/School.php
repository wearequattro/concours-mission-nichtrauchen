<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 * @package App
 *
 * @property int id
 * @property string name
 * @property string address
 * @property string postal_code
 * @property string city
 * @property string full_address
 * @property Carbon updated_at
 * @property Carbon created_at
 *
 * @method static School create(array $map)
 */
class School extends Model {

    protected $fillable = [
        'name',
        'address',
        'postal_code',
        'city',
    ];

    protected $appends = ['full_address'];

    public function getFullAddressAttribute() {
        return $this->address . " " . $this->postal_code . " " . $this->city;
    }

}

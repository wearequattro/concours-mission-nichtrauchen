<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
 * @property Collection classes All classes belonging to this school
 * @property Carbon updated_at
 * @property Carbon created_at
 *
 * @method static School create(array $map)
 * @method static School findOrFail(int $id)
 */
class School extends Model {

    protected $fillable = [
        'name',
        'address',
        'postal_code',
        'city',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(function (Builder $builder) {
            return $builder->orderBy('name');
        });
    }

    protected $appends = ['full_address'];

    public function getFullAddressAttribute() {
        return $this->address . " " . $this->postal_code . " " . $this->city;
    }

    public function classes() {
        return $this->hasMany(SchoolClass::class);
    }

}

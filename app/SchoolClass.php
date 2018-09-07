<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * Class SchoolClass
 * @package App
 *
 * @property int id
 * @property string name
 * @property int students
 * @property int school_id
 * @property int teacher_id
 * @property boolean status_january
 * @property boolean status_march
 * @property boolean status_may
 * @property boolean status_party
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property School school
 * @property Teacher teacher
 *
 * @method static SchoolClass create(array $values)
 */
class SchoolClass extends Model {

    protected $fillable = ['name', 'students', 'school_id', 'teacher_id', 'status_january', 'status_march',
        'status_may', 'status_party'];

    public function school(): BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * @param Teacher $teacher
     * @param string $name
     * @param int $students
     * @param School $school
     * @return SchoolClass The newly created SchoolClass
     */
    public static function createForTeacher(Teacher $teacher, $name, $students, School $school): SchoolClass {
        return SchoolClass::create([
            'name' => $name,
            'students' => $students,
            'school_id' => $school->id,
            'teacher_id' => $teacher->id,
        ]);
    }

    /**
     * Finds all {@link SchoolClass} objects for the currently logged in Teacher. If user is not a teacher, an empty
     * collection is returned
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public static function findForLoggedInUser(): Collection {
        if(\Auth::user() === null || \Auth::user()->type !== User::TYPE_TEACHER || \Auth::user()->teacher === null)
            return collect();
        return static::findForTeacher(\Auth::user()->teacher);
    }

    /**
     * Finds all {@link SchoolClass} objects for the given Teacher
     * @param Teacher $teacher
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public static function findForTeacher(Teacher $teacher): Collection {
        return static::query()
            ->where('teacher_id', $teacher->id)
            ->get();
    }

}

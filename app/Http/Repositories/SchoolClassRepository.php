<?php


namespace App\Http\Repositories;


use App\Http\Controllers\Controller;
use App\SchoolClass;
use App\Teacher;
use App\User;
use Illuminate\Support\Collection;

class SchoolClassRepository extends Controller {

    /**
     * Finds SchoolClass by one of its status tokens
     * @param string $token
     * @return SchoolClass|null
     */
    public function findByStatusToken(string $token): ?SchoolClass {
        return SchoolClass::query()
            ->where('january_token', $token)
            ->orWhere('march_token', $token)
            ->orWhere('may_token', $token)
            ->first();
    }

    /**
     * Finds SchoolClass by its party token
     * @param string $token
     * @return SchoolClass|null
     */
    public function findByPartyToken(string $token): ?SchoolClass {
        return SchoolClass::query()
            ->where('party_token', $token)
            ->first();
    }

    /**
     * Finds all {@link SchoolClass} objects for the currently logged in Teacher. If user is not a teacher, an empty
     * collection is returned
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public function findForLoggedInUser(): Collection {
        if (\Auth::user() === null || \Auth::user()->type !== User::TYPE_TEACHER || \Auth::user()->teacher === null)
            return collect();
        return static::findForTeacher(\Auth::user()->teacher);
    }

    /**
     * Finds all {@link SchoolClass} objects for the given Teacher
     * @param Teacher $teacher
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public function findForTeacher(Teacher $teacher): Collection {
        return SchoolClass::query()
            ->where('teacher_id', $teacher->id)
            ->get();
    }

}
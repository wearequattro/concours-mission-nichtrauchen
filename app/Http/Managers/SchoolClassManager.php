<?php


namespace App\Http\Managers;


use App\Http\Controllers\Controller;
use App\SchoolClass;

class SchoolClassManager extends Controller {

    /**
     * @param SchoolClass $class
     * @param string $token
     * @return string
     * @throws \Exception
     */
    public function determineStatusByToken(SchoolClass $class, string $token): string {
        if($class->january_token === $token)
            return SchoolClass::STATUS_JANUARY;
        if($class->march_token === $token)
            return SchoolClass::STATUS_MARCH;
        if($class->may_token === $token)
            return SchoolClass::STATUS_MAY;
        throw new \Exception('Class does not have specified token.');
    }

}
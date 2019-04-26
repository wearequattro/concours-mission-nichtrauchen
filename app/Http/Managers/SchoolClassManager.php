<?php


namespace App\Http\Managers;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Repositories\EmailRepository;
use App\Mail\CustomEmail;
use App\SchoolClass;

class SchoolClassManager extends Controller {

    /**
     * @var EmailRepository
     */
    private $emailRepository;

    public function __construct(EmailRepository $emailRepository) {
        $this->emailRepository = $emailRepository;
    }

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

    /**
     * @param SchoolClass $class
     * @param bool $status
     */
    public function handlePartyResponse(SchoolClass $class, bool $status) {
        $class->setPartyStatus($status);

        if(!$status) {
            $mail = $this->emailRepository->findPartyResponseNegative();
            \Mail::to($class->teacher->user->email)
                ->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }

}
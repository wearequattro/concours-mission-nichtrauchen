<?php

namespace App\Http\Controllers;

use App\EditableDate;
use App\EditableEmail;
use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use App\SchoolClass;
use function MongoDB\BSON\toJSON;

class PartyController extends Controller {

    /**
     * @var SchoolClassRepository
     */
    private $classRepository;
    /**
     * @var SchoolClassManager
     */
    private $classManager;

    public function __construct(SchoolClassRepository $classRepository, SchoolClassManager $classManager) {
        $this->classRepository = $classRepository;
        $this->classManager = $classManager;
    }

    public function handlePartyResponse(string $token, string $status) {
        $class = $this->classRepository->findByPartyToken($token);
        if(!$class)
            return redirect()->route('login.redirect');

        $newStatus = $status === "true";
        $this->classManager->handlePartyResponse($class, $newStatus);

        if($newStatus)
            return redirect()->route('teacher.party');
        return redirect()->route('login.redirect');
    }

    public function sendReminders() {
        // party participation reminders
        SchoolClass::all()
            ->filter(function (SchoolClass $class) {
                return $this->classManager->shouldSendPartyReminder($class);
            })
            ->each(function (SchoolClass $class) {
                $this->sendPartyInviteReminder($class);
            });

        // party group reminders
        SchoolClass::all()
            ->filter(function (SchoolClass $class) {
                return $this->classManager->shouldSendPartyGroupReminder($class);
            })
            ->each(function (SchoolClass $class) {
                $this->sendPartyGroupReminder($class);
            });
    }

    public function sendPartyInvite(SchoolClass $class) {
        \Log::info('Sending party invite to: ' . $class->toJSON());
        $class->prepareSendParty();
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail(EditableEmail::find(EditableEmail::$MAIL_INVITE_PARTY), $class->teacher, $class));
    }

    public function sendPartyInviteReminder(SchoolClass $class) {
        \Log::info('Sending party invite reminder to: ' . $class->toJSON());
        $class->prepareSendPartyReminder();
        $mail = EditableEmail::find(EditableEmail::$MAIL_INVITE_PARTY_REMINDER);
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail($mail, $class->teacher, $class));
    }

    public function sendPartyGroupReminder(SchoolClass $class) {
        \Log::info('Sending party group reminder to: ' . $class->toJSON());
        $mail = EditableEmail::find(EditableEmail::$MAIL_PARTY_GROUP_REMINDER);
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail($mail, $class->teacher, $class));
    }

}
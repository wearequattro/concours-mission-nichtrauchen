<?php

namespace App\Http\Controllers;

use App\EditableEmail;
use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\EmailRepository;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use App\SchoolClass;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;

class FollowUpController extends Controller {

    /**
     * @var EmailRepository
     */
    private $emailRepository;

    /**
     * @var SchoolClassRepository
     */
    private $classRepository;
    /**
     * @var SchoolClassManager
     */
    private $classManager;
    /**
     * @var PartyController
     */
    private $partyController;

    public function __construct(
        EmailRepository $emailRepository,
        SchoolClassRepository $classRepository,
        SchoolClassManager $classManager,
        PartyController $partyController
    ) {
        $this->emailRepository = $emailRepository;
        $this->classRepository = $classRepository;
        $this->classManager = $classManager;
        $this->partyController = $partyController;
    }

    public function sendFollowUpForAll() {
        SchoolClass::all()->each(function (SchoolClass $class) {
            try {
                $this->sendFollowUp($class);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Bugsnag::notify($e);
            }
        });
    }

    /**
     * @param SchoolClass $schoolClass
     * @throws \Exception
     */
    public function sendFollowUp(SchoolClass $schoolClass) {
        // Determine which status to send next
        $statuses = collect([
//            SchoolClass::STATUS_JANUARY,
//            SchoolClass::STATUS_MARCH,
            SchoolClass::STATUS_MAY
        ]);
        foreach ($statuses as $status) {
            if ($this->classManager->shouldSendFollowUp($schoolClass, $status)) {
                $this->sendFollowUpMail($schoolClass, $status);
                break;
            } else if ($this->classManager->shouldSendFollowUpReminder($schoolClass, $status)) {
                $this->sendFollowUpReminderMail($schoolClass, $status);
                break;
            }
        }
    }

    /**
     * @param SchoolClass $class
     * @param string $status
     * @throws \Exception
     */
    function sendFollowUpMail(SchoolClass $class, string $status) {
        Log::info('Sending follow up for ' . $status . ' to ' . $class->teacher->user->email);
        $class->prepareSend($status);
        $mail = $this->emailRepository->findFollowUpForStatus($status);
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail(EditableEmail::find($mail), $class->teacher, $class));
    }

    /**
     * @param SchoolClass $class
     * @param string $status
     * @throws \Exception
     */
    function sendFollowUpReminderMail(SchoolClass $class, string $status) {
        Log::info('Sending follow up reminder for ' . $status . ' to ' . $class->teacher->user->email);
        $class->prepareSendReminder($status);
        $mail = $this->emailRepository->findFollowUpReminderForStatus($status);
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail(EditableEmail::find($mail), $class->teacher, $class));
    }

    public function setFollowUpStatus(string $token, $stillNonSmoking) {
        $newStatus = $stillNonSmoking === "true";
        Log::info("Teacher responded to follow up: $token");
        $class = $this->classRepository->findByStatusToken($token);
        if(!$class)
            return redirect()->route('login.redirect');

        try {
            $status = $this->classManager->determineStatusByToken($class, $token);
            $class->setFollowUpStatus($status, $newStatus);
            $this->sendFollowUpReplyToResponse($class, $status, $newStatus);
        } catch (\Exception $e) {
            Log::error($e);
            Bugsnag::notifyException($e);
        }
        return redirect()->route('login.redirect');
    }

    /**
     * Sends the appropriate reply to the teacher's follow up response.
     * @param SchoolClass $class
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @param bool $newStatus
     * @throws \Exception
     */
    function sendFollowUpReplyToResponse(SchoolClass $class, $whichStatus, bool $newStatus) {
        $mailToSend = null;
        if ($newStatus === false) { // no
            \Log::info('Sending negative response to follow up ' . $whichStatus);
            $mailToSend = $this->emailRepository->findFollowUpResponseNegativeForStatus($whichStatus);
        }
        if ($newStatus === true && $whichStatus == SchoolClass::STATUS_MAY) { // yes, party
            $this->partyController->sendPartyInvite($class);
            return;
        }
        if ($newStatus === true && $whichStatus !== SchoolClass::STATUS_MAY) { // yes, normal
            \Log::info('Sending positive response to follow up ' . $whichStatus);
            $mailToSend = $this->emailRepository->findFollowUpResponsePositiveForStatus($whichStatus);
        }
        if ($mailToSend != null) {
            \Mail::to($class->teacher->user->email)
                ->queue(new CustomEmail(EditableEmail::find($mailToSend), $class->teacher, $class));
        }
    }


}

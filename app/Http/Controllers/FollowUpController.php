<?php

namespace App\Http\Controllers;

use App\EditableEmail;
use App\Mail\CustomEmail;
use App\SchoolClass;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;

class FollowUpController extends Controller {

    /**
     * @var EmailRepository
     */
    private $emailRepository;

    public function __construct(EmailRepository $emailRepository) {
        $this->emailRepository = $emailRepository;
    }

    public function setFollowUpStatus(string $token, $status) {
        Log::info('Teacher responded to follow up');
        SchoolClass::setFollowUpStatus($token, $status === "true");
        return redirect()->route('login.redirect');
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
        $statuses = collect([SchoolClass::STATUS_JANUARY, SchoolClass::STATUS_MARCH, SchoolClass::STATUS_MAY]);
        foreach ($statuses as $status) {
            if ($schoolClass->shouldSendFollowUp($status)) {
                Log::info('Sending follow up for '. $status . ' to ' . $schoolClass->teacher->user->email);
                $schoolClass->prepareSend($status);
                $this->sendFollowUpMail($schoolClass, $status);
                break;
            } else if ($schoolClass->shouldSendFollowUpReminder($status)) {
                Log::info('Sending follow up reminder for '. $status . ' to ' . $schoolClass->teacher->user->email);
                $schoolClass->prepareSendReminder($status);
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
        $mail = $this->emailRepository->findFollowUpReminderForStatus($status);
        \Mail::to($class->teacher->user->email)
            ->queue(new CustomEmail(EditableEmail::find($mail), $class->teacher, $class));
    }

    public function setPartyStatus(string $token, string $status) {

    }

}

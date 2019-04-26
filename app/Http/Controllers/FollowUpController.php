<?php

namespace App\Http\Controllers;

use App\EditableEmail;
use App\Http\Controllers\Repositories\EmailRepository;
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
                Log::info('Sending follow up for ' . $status . ' to ' . $schoolClass->teacher->user->email);
                $schoolClass->prepareSend($status);
                $this->sendFollowUpMail($schoolClass, $status);
                break;
            } else if ($schoolClass->shouldSendFollowUpReminder($status)) {
                Log::info('Sending follow up reminder for ' . $status . ' to ' . $schoolClass->teacher->user->email);
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

    public function setFollowUpStatus(string $token, $stillNonSmoking) {
        $newStatus = $stillNonSmoking === "true";
        Log::info("Teacher responded to follow up: $token");
        $class = SchoolClass::findByStatusToken($token);
        abort_if(!$class, 404, "Ce lien n'est plus valable.");

        try {
            $status = $class->determineStatusByToken($token);
            $class->setFollowUpStatus($status, $newStatus);
            $this->sendFollowUpReplyToResponse($class, $status, $newStatus);
        } catch (\Exception $e) {
            abort(404, "Une erreur s'est produite lors du traitement de votre demande.");
            Bugsnag::notify($e);
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
        } else { // yes
            \Log::info('Sending positive response to follow up ' . $whichStatus);
            $mailToSend = $this->emailRepository->findFollowUpResponsePositiveForStatus($whichStatus);
        }
        if ($mailToSend != null) {
            \Mail::to($class->teacher->user->email)
                ->queue(new CustomEmail(EditableEmail::find($mailToSend), $class->teacher, $class));
        }
    }


}

<?php


namespace App\Http\Managers;


use App\EditableDate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Repositories\EmailRepository;
use App\Mail\CustomEmail;
use App\SchoolClass;
use Carbon\Carbon;

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

    /**
     * Determines if sent_at is not set and that "now" is after the followUp date in env.
     * @param SchoolClass $class
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @return bool
     */
    public function shouldSendFollowUp(SchoolClass $class, string $whichStatus): bool {
        $followupDate = null;
        if ($whichStatus === SchoolClass::STATUS_JANUARY)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_1);
        if ($whichStatus === SchoolClass::STATUS_MARCH)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_2);
        if ($whichStatus === SchoolClass::STATUS_MAY)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_3);

        $sentAtName = $whichStatus . '_sent_at';
        $statusValue = $class->__get('status_' . $whichStatus);
        /** @var Carbon $sentAt */
        $sentAt = $class->$sentAtName;
        return $class->arePreviousStatusesPositive($whichStatus)
            && $sentAt === null
            && $statusValue === null
            && Carbon::now()->gte($followupDate);
    }

    /**
     * Checks if the follow up for the given status is sent, and it was at least some time ago (configurable in env).
     * @param SchoolClass $class
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @param bool $checkIfAlreadySent Checks if the email reminder has already been sent.
     * @return bool
     */
    public function shouldSendFollowUpReminder(SchoolClass $class, string $whichStatus, $checkIfAlreadySent = true): bool {
        $sentAtName = $whichStatus . '_sent_at';
        $reminderSentAtName = $whichStatus . '_reminder_sent_at';
        /** @var Carbon $sentAt */
        $sentAt = $class->$sentAtName;
        /** @var Carbon $reminderSentAt */
        $reminderSentAt = $class->$reminderSentAtName;
        if ($sentAt === null || !$class->arePreviousStatusesPositive($whichStatus))
            return false;
        $statusValue = $class->__get('status_' . $whichStatus);
        if ($statusValue !== null)
            return false;
        $followupReminderDate = $sentAt->copy()->addDays(env('FOLLOW_UP_MAIL_RESEND_DELAY_DAYS'));// todo use proper dates
        if(!$checkIfAlreadySent) {
            $followupReminderDate = Carbon::create(2000, 1, 1, 0, 0, 0);
            $reminderSentAt = null;
        }
        return $reminderSentAt === null && Carbon::now()->gte($followupReminderDate);
    }

}
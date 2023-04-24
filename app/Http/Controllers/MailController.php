<?php

namespace App\Http\Controllers;

use App\EditableDate;
use App\EditableEmail;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private $schoolClassRepository;

    public function __construct(SchoolClassRepository $schoolClassRepository)
    {
        $this->schoolClassRepository = $schoolClassRepository;
    }

    public function sendFinalMails()
    {
        // Send final mail to classes not eligible to
        // participate to the party
        $this->sendFinalMail();

        // Send party invitation mail to classes eligible to
        // participate to the party
        $this->sendPartyInvite();

        // Send party invitation reminder mail to classes eligible to
        // participate to the party that haven't registered yet
        $this->sendPartyInviteReminder();
    }

    public function sendFinalMail()
    {
        $date = EditableDate::find(EditableDate::FINAL_MAIL);
        $mail = EditableEmail::find(EditableEmail::$MAIL_FINAL);
        // is start date today?
        if (!$date->isCurrentDay()) {
            return;
        }

        Log::info('Sending ' . EditableEmail::$MAIL_FINAL[0]);

        $classes = $this->schoolClassRepository->findNotEligibleForFinalParty();
        foreach ($classes as $class) {
            if($mail->isSentToClass($class)) {
                Log::info("Mail already sent to {$class->name} ({$class->id}), skipping...");
                continue;
            }
            Log::info("Sending mail to {$class->name} ({$class->id})");
            Mail::to($class->teacher->user->email)->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }

    public function sendPartyInvite()
    {
        $date = EditableDate::find(EditableDate::FINAL_INVITATION_PARTY);
        $mail = EditableEmail::find(EditableEmail::$MAIL_INVITE_PARTY);
        // is start date today?
        if (!$date->isCurrentDay()) {
            return;
        }

        Log::info('Sending ' . EditableEmail::$MAIL_INVITE_PARTY[0]);

        $classes = $this->schoolClassRepository->findEligibleForFinalParty();
        foreach ($classes as $class) {
            if($mail->isSentToClass($class)) {
                Log::info("Mail already sent to {$class->name} ({$class->id}), skipping...");
                continue;
            }
            Log::info("Sending mail to {$class->name} ({$class->id})");
            Mail::to($class->teacher->user->email)->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }

    public function sendPartyInviteReminder()
    {
        $date = EditableDate::find(EditableDate::FINAL_INVITATION_PARTY_REMINDER);
        $mail = EditableEmail::find(EditableEmail::$MAIL_INVITE_PARTY_REMINDER);
        // is start date today?
        if (!$date->isCurrentDay()) {
            return;
        }

        Log::info('Sending ' . EditableEmail::$MAIL_INVITE_PARTY_REMINDER[0]);

        $classes = $this->schoolClassRepository->findEligibleForFinalPartyReminder();
        foreach ($classes as $class) {
            if($mail->isSentToClass($class)) {
                Log::info("Mail already sent to {$class->name} ({$class->id}), skipping...");
                continue;
            }
            Log::info("Sending mail to {$class->name} ({$class->id})");
            Mail::to($class->teacher->user->email)->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\EditableDate;
use App\EditableEmail;
use App\Mail\CustomEmail;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NewsletterController extends Controller {

    const sendingHour = 7;

    public function sendNewsletters() {
        $teachers = Teacher::all();
        $this->send($teachers, EditableDate::NEWSLETTER_START, EditableEmail::$MAIL_NEWSLETTER_START);
        $this->send($teachers, EditableDate::NEWSLETTER_ENCOURAGEMENT, EditableEmail::$MAIL_NEWSLETTER_ENCOURAGEMENT);
    }

    private function send(Collection $teachers, string $dateIdentifier, array $mailIdentifier) {
        $date = EditableDate::find($dateIdentifier);
        $mail = EditableEmail::find($mailIdentifier);
        \Log::info("Trying to send mail " . $mail->key);
        // is start date today?
        if (!$date->isCurrentDay()) {
            \Log::info("$date is not today.. exiting");
            return;
        }

        if (Carbon::now()->hour != NewsletterController::sendingHour) {
            \Log::info(Carbon::now()->hour . " is not the sending hour (" . NewsletterController::sendingHour . ")");
            return;
        }

        $teachers->each(function (Teacher $teacher) use ($mail) {
            $shouldSend = !$mail->isSentToUser($teacher->user);
            if ($shouldSend) {
                \Log::info("Sending to teacher $teacher->full_name");
                \Mail::to($teacher->user->email)->queue(new CustomEmail($mail, $teacher, null));
            }
        });
    }

}

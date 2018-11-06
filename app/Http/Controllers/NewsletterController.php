<?php

namespace App\Http\Controllers;

use App\EditableDate;
use App\EditableEmail;
use App\Mail\CustomEmail;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NewsletterController extends Controller {

    const sendingHour = 10;

    public function sendNewsletters() {
        $teachers = Teacher::all();
        $teachersStillParticipating = $teachers->filter(function (Teacher $teacher) {
            return $teacher->isStillParticipating();
        });
        $this->send($teachers, EditableDate::NEWSLETTER_START, EditableEmail::$MAIL_NEWSLETTER_START);
        $this->send($teachersStillParticipating, EditableDate::NEWSLETTER_ENCOURAGEMENT, EditableEmail::$MAIL_NEWSLETTER_ENCOURAGEMENT);
        $this->send($teachers, EditableDate::FINAL_MAIL, EditableEmail::$MAIL_FINAL);
    }

    private function send(Collection $teachers, string $dateIdentifier, array $mailIdentifier) {
        $date = EditableDate::find($dateIdentifier);
        $mail = EditableEmail::find($mailIdentifier);
        // is start date today?
        if (!$date->isCurrentDay()) {
            return;
        }

        if (Carbon::now()->hour < NewsletterController::sendingHour) {
            return;
        }
        \Log::info('Sending ' . $mailIdentifier[0]);

        $teachers->each(function (Teacher $teacher) use ($mail) {
            $shouldSend = !$mail->isSentToUser($teacher->user);
            if ($shouldSend) {
                \Log::info("Sending to teacher $teacher->full_name");
                if ($teacher->classes()->exists()) {
                    foreach ($teacher->classes as $class) {
                        \Mail::to($teacher->user->email)->queue(new CustomEmail($mail, $teacher, $class));
                    }
                } else {
                    \Mail::to($teacher->user->email)->queue(new CustomEmail($mail, $teacher, null));
                }
            }
        });
    }

}

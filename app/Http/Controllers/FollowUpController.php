<?php

namespace App\Http\Controllers;

use App\SchoolClass;

class FollowUpController extends Controller {

    public function setFollowUpStatus(string $token, $status) {
        SchoolClass::setFollowUpStatus($token, $status === "true");
        return redirect('/');
    }

    public function sendFollowUpForAll() {
        SchoolClass::all()->each(function (SchoolClass $class) {
            $this->sendFollowUp($class);
        });
    }

    public function sendFollowUp(SchoolClass $schoolClass) {
        // Determine which status to send next
        $statuses = collect([SchoolClass::STATUS_JANUARY, SchoolClass::STATUS_MARCH, SchoolClass::STATUS_MAY]);
        foreach ($statuses as $status) {
            if ($schoolClass->shouldSendFollowUp($status)) {
                $schoolClass->sendFollowUpEmail($status);
                break;
            } else if ($schoolClass->shouldSendFollowUpReminder($status)) {
                $schoolClass->sendFollowUpReminderEmail($status);
                break;
            }
        }

    }

}

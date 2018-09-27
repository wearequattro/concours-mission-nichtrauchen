<?php

namespace App\Http\Controllers;

use App\SchoolClass;
use Illuminate\Support\Facades\Log;

class FollowUpController extends Controller {

    public function setFollowUpStatus(string $token, $status) {
        Log::info('Teacher responded to follow up');
        SchoolClass::setFollowUpStatus($token, $status === "true");
        return redirect()->route('login.redirect');
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
                Log::info('Sending follow up for '. $status . ' to ' . $schoolClass->teacher->user->email);
                $schoolClass->sendFollowUpEmail($status);
                break;
            } else if ($schoolClass->shouldSendFollowUpReminder($status)) {
                Log::info('Sending follow up reminder for '. $status . ' to ' . $schoolClass->teacher->user->email);
                $schoolClass->sendFollowUpReminderEmail($status);
                break;
            }
        }

    }

}

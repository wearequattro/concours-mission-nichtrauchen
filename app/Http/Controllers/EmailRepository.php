<?php


namespace App\Http\Controllers;


use App\EditableEmail;
use App\SchoolClass;

class EmailRepository extends Controller {

    public function findFollowUpForStatus(string $status): array {
        if($status == SchoolClass::STATUS_JANUARY)
            return EditableEmail::$MAIL_FOLLOW_UP_1;
        if($status == SchoolClass::STATUS_MARCH)
            return EditableEmail::$MAIL_FOLLOW_UP_2;
        if($status == SchoolClass::STATUS_MAY)
            return EditableEmail::$MAIL_FOLLOW_UP_3;
        throw new \Exception("no follow up mail exists for status: $status");
    }

    public function findFollowUpReminderForStatus(string $status): array {
        if($status == SchoolClass::STATUS_JANUARY)
            return EditableEmail::$MAIL_FOLLOW_UP_1_REMINDER;
        if($status == SchoolClass::STATUS_MARCH)
            return EditableEmail::$MAIL_FOLLOW_UP_2_REMINDER;
        if($status == SchoolClass::STATUS_MAY)
            return EditableEmail::$MAIL_FOLLOW_UP_3_REMINDER;
        throw new \Exception("no follow up mail exists for status: $status");
    }

    public function findFollowUpResponseNegativeForStatus(string $status): array {
        if($status == SchoolClass::STATUS_JANUARY)
            return EditableEmail::$MAIL_FOLLOW_UP_1_NO;
        if($status == SchoolClass::STATUS_MARCH)
            return EditableEmail::$MAIL_FOLLOW_UP_2_NO;
        if($status == SchoolClass::STATUS_MAY)
            return EditableEmail::$MAIL_FOLLOW_UP_3_NO;
        throw new \Exception("no follow up mail exists for status: $status");
    }

    public function findFollowUpResponsePositiveForStatus(string $status): array {
        if($status == SchoolClass::STATUS_JANUARY)
            return EditableEmail::$MAIL_FOLLOW_UP_1_YES;
        if($status == SchoolClass::STATUS_MARCH)
            return EditableEmail::$MAIL_FOLLOW_UP_2_YES;
        if($status == SchoolClass::STATUS_MAY)
            return EditableEmail::$MAIL_FOLLOW_UP_3_YES_INVITE_PARTY;
        throw new \Exception("no follow up mail exists for status: $status");
    }

}
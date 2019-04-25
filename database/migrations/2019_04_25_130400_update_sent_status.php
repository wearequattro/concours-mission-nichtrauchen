<?php

use App\EditableEmail;
use App\SchoolClass;
use Illuminate\Database\Migrations\Migration;

class UpdateSentStatus extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $classes = SchoolClass::all();
        foreach ($classes as $class) {
            /** @var $class SchoolClass */
            $sentEmails = [];
            if($class->january_sent_at !== null)
                $sentEmails[] = EditableEmail::$MAIL_FOLLOW_UP_1[0];
            if($class->january_reminder_sent_at !== null)
                $sentEmails[] = EditableEmail::$MAIL_FOLLOW_UP_1_REMINDER[0];
            if($class->march_sent_at !== null)
                $sentEmails[] = EditableEmail::$MAIL_FOLLOW_UP_2[0];
            if($class->march_reminder_sent_at !== null)
                $sentEmails[] = EditableEmail::$MAIL_FOLLOW_UP_2_REMINDER[0];

            if(sizeof($sentEmails) == 0)
                continue;

            foreach ($sentEmails as $key) {
                \App\SentEmail::create([
                    'editable_email_key' => $key,
                    'user_id' => $class->teacher->user->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}

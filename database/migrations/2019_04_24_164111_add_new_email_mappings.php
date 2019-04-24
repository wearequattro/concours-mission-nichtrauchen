<?php

use App\EditableDate;
use App\EditableEmail;
use Illuminate\Database\Migrations\Migration;

class AddNewEmailMappings extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $mapping = [
            EditableEmail::$MAIL_FOLLOW_UP_1[0] => EditableDate::FOLLOW_UP_1,
            EditableEmail::$MAIL_FOLLOW_UP_1_NO[0] => EditableDate::FOLLOW_UP_1,
            EditableEmail::$MAIL_FOLLOW_UP_1_YES[0] => EditableDate::FOLLOW_UP_1,
            EditableEmail::$MAIL_FOLLOW_UP_1_REMINDER[0] => EditableDate::FOLLOW_UP_1_REMINDER,
            EditableEmail::$MAIL_FOLLOW_UP_2[0] => EditableDate::FOLLOW_UP_2,
            EditableEmail::$MAIL_FOLLOW_UP_2_NO[0] => EditableDate::FOLLOW_UP_2,
            EditableEmail::$MAIL_FOLLOW_UP_2_YES[0] => EditableDate::FOLLOW_UP_2,
            EditableEmail::$MAIL_FOLLOW_UP_2_REMINDER[0] => EditableDate::FOLLOW_UP_2_REMINDER,
            EditableEmail::$MAIL_FOLLOW_UP_3[0] => EditableDate::FOLLOW_UP_3,
            EditableEmail::$MAIL_FOLLOW_UP_3_NO[0] => EditableDate::FOLLOW_UP_3,
            EditableEmail::$MAIL_FOLLOW_UP_3_YES_INVITE_PARTY[0] => EditableDate::FOLLOW_UP_3,
            EditableEmail::$MAIL_PARTY_NO[0] => EditableDate::FOLLOW_UP_3,
            EditableEmail::$MAIL_PARTY_YES[0] => EditableDate::FOLLOW_UP_3,
            EditableEmail::$MAIL_FOLLOW_UP_3_REMINDER[0] => EditableDate::FOLLOW_UP_3_REMINDER,
        ];
        foreach ($mapping as $email => $date) {
            DB::table('editable_date_editable_email')->insert([
                'editable_email_key' => $email,
                'editable_date_key' => $date,
            ]);
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

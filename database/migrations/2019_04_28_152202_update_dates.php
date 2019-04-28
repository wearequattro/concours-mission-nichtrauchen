<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\EditableDate::updateOrAdd();
        DB::table('editable_date_editable_email')
            ->insert([
                [
                    'editable_email_key' => \App\EditableEmail::$MAIL_INVITE_PARTY_REMINDER[0],
                    'editable_date_key' => \App\EditableDate::INVITE_PARTY_REMINDER,
                ],
                [
                    'editable_email_key' => \App\EditableEmail::$MAIL_PARTY_GROUP_REMINDER[0],
                    'editable_date_key' => \App\EditableDate::PARTY_GROUP_REMINDER,
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

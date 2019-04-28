<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('editable_emails')
            ->where('key', 'follow_up_yes_invite_party')
            ->update(['key' => \App\EditableEmail::$MAIL_INVITE_PARTY[0]]);
        \App\EditableEmail::updateEmails();
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

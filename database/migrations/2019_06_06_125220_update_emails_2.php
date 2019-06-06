<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmails2 extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        \App\EditableEmail::updateEmails();

        DB::table('editable_date_editable_email')
            ->insert([
                'editable_email_key' => \App\EditableEmail::$MAIL_FINAL_CERTIFICAT[0],
                'editable_date_key' => \App\EditableDate::FINAL_MAIL,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}

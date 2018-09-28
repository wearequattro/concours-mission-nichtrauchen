<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateLabels extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        \App\EditableEmail::find(\App\EditableEmail::$MAIL_NEWSLETTER_START);
        \App\EditableEmail::find(\App\EditableEmail::$MAIL_NEWSLETTER_ENCOURAGEMENT);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

    }
}

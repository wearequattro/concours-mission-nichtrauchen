<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartyGroupReminderDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dateTime('party_group_reminder_sent_at')->after('party_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('party_group_reminder_sent_at');
        });
    }
}

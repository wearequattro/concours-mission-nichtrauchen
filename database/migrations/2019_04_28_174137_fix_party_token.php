<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixPartyToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('party_token');
        });
        Schema::table('school_classes', function (Blueprint $table) {
            $table->string('party_token')->after('party_reminder_sent_at')->nullable();
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
            $table->dropColumn('party_token');
        });
        Schema::table('school_classes', function (Blueprint $table) {
            $table->boolean('party_token')->after('party_reminder_sent_at')->nullable();
        });
    }
}

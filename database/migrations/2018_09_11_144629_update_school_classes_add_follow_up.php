<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSchoolClassesAddFollowUp extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->string('january_token')->nullable()->after('status_january');
            $table->dateTime('january_sent_at')->nullable()->after('january_token');
            $table->dateTime('january_reminder_sent_at')->nullable()->after('january_sent_at');

            $table->string('march_token')->nullable()->after('january_reminder_sent_at');
            $table->dateTime('march_sent_at')->nullable()->after('march_token');
            $table->dateTime('march_reminder_sent_at')->nullable()->after('march_sent_at');

            $table->string('may_token')->nullable()->after('march_reminder_sent_at');
            $table->dateTime('may_sent_at')->nullable()->after('may_token');
            $table->dateTime('may_reminder_sent_at')->nullable()->after('may_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn([
                'january_token', 'january_sent_at', 'january_reminder_sent_at', 'march_token', 'march_sent_at',
                'march_reminder_sent_at', 'may_token', 'may_sent_at', 'may_reminder_sent_at'
            ]);
        });
    }
}

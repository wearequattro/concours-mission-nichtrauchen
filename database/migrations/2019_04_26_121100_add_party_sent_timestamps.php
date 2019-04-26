<?php

use App\EditableEmail;
use App\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPartySentTimestamps extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dateTime('party_sent_at')->after('status_party')->nullable();
            $table->dateTime('party_reminder_sent_at')->after('party_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('party_sent_at');
            $table->dropColumn('party_reminder_sent_at');
        });
    }
}

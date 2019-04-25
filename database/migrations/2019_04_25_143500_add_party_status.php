<?php

use App\EditableEmail;
use App\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPartyStatus extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->boolean('status_party')->nullable()->after('status_may');
            $table->boolean('party_token')->nullable()->after('status_party');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('status_party');
            $table->dropColumn('party_token');
        });
    }
}

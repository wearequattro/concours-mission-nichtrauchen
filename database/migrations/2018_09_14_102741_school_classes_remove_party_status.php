<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchoolClassesRemovePartyStatus extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('status_party');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->boolean('status_party')->nullable();
        });
    }
}

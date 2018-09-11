<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyRegistrationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('party_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('students');
            $table->string('language');
            $table->integer('school_class_id')->unsigned();
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('party_registrations');
    }
}

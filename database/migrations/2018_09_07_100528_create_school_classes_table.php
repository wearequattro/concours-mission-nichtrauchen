<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolClassesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('students')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->boolean('status_january')->nullable();
            $table->boolean('status_march')->nullable();
            $table->boolean('status_may')->nullable();
            $table->boolean('status_party')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('school_classes');
    }
}

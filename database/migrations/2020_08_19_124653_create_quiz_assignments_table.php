<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_in_language_id');
            $table->unsignedInteger('school_class_id');
            $table->string('code')->nullable();
            $table->timestamps();

            $table->foreign('quiz_in_language_id')->references('id')->on('quiz_in_languages')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign(['school_class_id'])->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_assignments');
    }
}

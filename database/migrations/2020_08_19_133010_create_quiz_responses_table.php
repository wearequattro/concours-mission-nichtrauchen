<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_assignment_id');
            $table->integer('score');
            $table->integer('quizmaker_response_id');

            $table->timestamps();

            $table->foreign('quiz_assignment_id')->references('id')->on('quiz_assignments')
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
        Schema::dropIfExists('quiz_responses');
    }
}

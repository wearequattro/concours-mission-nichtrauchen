<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizInLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_in_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->char('language', 2);
            $table->unsignedInteger('quiz_id');
            $table->string('quiz_maker_id');
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quizzes')
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
        Schema::dropIfExists('quiz_in_languages');
    }
}

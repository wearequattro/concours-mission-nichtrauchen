<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_assignment_id');
            $table->unsignedInteger('quiz_in_language_id');
            $table->string('code');
            $table->timestamps();

            $table->foreign('quiz_assignment_id')->references('id')->on('quiz_assignments')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('quiz_in_language_id')->references('id')->on('quiz_in_languages')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_codes');

        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->string('code');
        });
    }
}

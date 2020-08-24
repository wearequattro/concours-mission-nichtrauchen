<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuizStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->dropForeign(['quiz_in_language_id']);
            $table->dropColumn('quiz_in_language_id');

            $table->unsignedInteger('quiz_id')->after('school_class_id');
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
        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn('quiz_id');

            $table->unsignedInteger('quiz_in_language_id');
            $table->foreign('quiz_in_language_id')->references('id')->on('quiz_in_languages')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
}

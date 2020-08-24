<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResponsesAddTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->timestamp('responded_at')->nullable()->after('quizmaker_response_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_responses', function (Blueprint $table) {
            $table->dropColumn('responded_at');
        });
    }
}

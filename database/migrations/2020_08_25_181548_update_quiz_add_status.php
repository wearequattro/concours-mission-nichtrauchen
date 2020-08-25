<?php

use App\Quiz;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuizAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table
                ->enum('state', [
                    Quiz::STATE_NEW,
                    Quiz::STATE_RUNNING,
                    Quiz::STATE_CLOSED,
                ])
                ->after('closes_at')
                ->default(Quiz::STATE_NEW);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
}

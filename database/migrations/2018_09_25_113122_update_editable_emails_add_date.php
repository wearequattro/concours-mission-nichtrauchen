<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEditableEmailsAddDate extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('editable_date_editable_email', function (Blueprint $table) {
            $table->string('editable_email_key');
            $table->string('editable_date_key');

            $table->foreign('editable_email_key')->references('key')->on('editable_emails')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('editable_date_key')->references('key')->on('editable_dates')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        $emailDates = [
            'teacher_confirmation' => [
                'TEACHER_INSCRIPTION_START',
            ],
            'contest_start' => [
                'TEACHER_INSCRIPTION_END',
            ],
            'follow_up' => [
                'FOLLOW_UP_1',
                'FOLLOW_UP_2',
                'FOLLOW_UP_3',
            ],
            'final' => [
                'FINAL_MAIL',
            ],
            'newsletter_start' => [
                'NEWSLETTER_START',
            ],
            'newsletter_encouragement' => [
                'NEWSLETTER_ENCOURAGEMENT',
            ],
        ];
        foreach ($emailDates as $email => $dates) {
            $m = \App\EditableEmail::findByKey($email);
            $m->dates()->sync($dates);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('editable_date_editable_email');
    }
}

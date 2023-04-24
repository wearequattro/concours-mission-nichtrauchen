<?php

use App\EditableDate;
use App\EditableEmail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanEditableMailAndDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $editableEmailsDelete = [
            'final_certificat',
            'follow_up_3',
            'follow_up_3_no',
            'follow_up_3_reminder',
            'newsletter_1',
            'newsletter_2',
            'party_confirmation_no',
            'party_confirmation_reminder',
        ];
        EditableEmail::whereIn('key', $editableEmailsDelete)->delete();

        EditableEmail::updateOrCreate([
            'key' => 'final',
        ], [
            'title' => 'Mail final',
            'subject' => 'Mission Nichtrauchen | Clôture',
        ]);

        EditableEmail::updateOrCreate([
            'key' => 'invite_party',
        ], [
            'title' => 'Invitation à la fête de clôture',
            'subject' => 'Mission Nichtrauchen | Invitation à la fête de clôture - 8 juin 2023',
        ]);

        EditableEmail::updateOrCreate([
            'key' => 'invite_party_reminder',
        ], [
            'title' => 'Invitation à la fête de clôture [RAPPEL]',
            'subject' => 'Mission Nichtrauchen | Rappel : Invitation à la fête de clôture - 8 juin 2023',
        ]);

        $editableDatesDelete = [
            'FOLLOW_UP_1',
            'FOLLOW_UP_1_REMINDER',
            'FOLLOW_UP_2',
            'FOLLOW_UP_2_REMINDER',
            'FOLLOW_UP_3',
            'FOLLOW_UP_3_REMINDER',
            'NEWSLETTER_1',
            'NEWSLETTER_2',
            'NEWSLETTER_ENCOURAGEMENT',
            'PARTY_GROUP_REMINDER',
            'PARTY_REMINDER',
        ];
        EditableDate::whereIn('key', $editableDatesDelete)->delete();

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY',
        ], [
            'label' => 'Mail invitation à la fête',
            'description' => 'Classes ayant répondu à au moins 5 des 6 quiz',
            'value' => '2030-04-19',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY_REMINDER',
        ], [
            'label' => 'Mail invitation à la fête [RAPPEL]',
            'description' => 'Classes ayant répondu à au moins 5 des 6 quiz',
            'value' => '2030-04-19',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_MAIL',
        ], [
            'label' => 'Mail fin de concours',
            'description' => 'Classes ayant répondu à moins de 5 des 6 quiz',
            'value' => '2030-04-19',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_MAIL',
        ], [
            'label' => 'Mail fin de concours',
            'description' => 'Classes ayant répondu à moins de 5 des 6 quiz',
            'value' => '2030-04-19',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

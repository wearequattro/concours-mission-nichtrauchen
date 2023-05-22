<?php

use App\EditableDate;
use App\EditableEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSecondMailReminderForFinalParty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EditableEmail::updateOrCreate([
            'key' => 'invite_party_reminder_second',
        ], [
            'title' => 'Invitation à la fête de clôture [DEUXIÈME RAPPEL]',
            'subject' => 'Mission Nichtrauchen | Rappel : Invitation à la fête de clôture - 8 juin 2023',
            'text' => '',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY_REMINDER_SECOND',
        ], [
            'label' => 'Mail invitation à la fête [DEUXIÈME RAPPEL]',
            'description' => 'Classes ayant répondu à au moins 5 des 6 quiz',
            'value' => Carbon::now()->addYears(10),
        ]);

        DB::table('editable_date_editable_email')
        ->updateOrInsert([
            'editable_email_key' => 'invite_party_reminder_second',
        ], [
            'editable_date_key' => 'FINAL_INVITATION_PARTY_REMINDER_SECOND',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EditableEmail::where('key', 'invite_party_reminder_second')->delete();
        EditableDate::where('key', 'FINAL_INVITATION_PARTY_REMINDER_SECOND')->delete();
    }
}

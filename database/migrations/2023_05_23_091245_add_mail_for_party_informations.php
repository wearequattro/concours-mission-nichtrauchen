<?php

use App\EditableDate;
use App\EditableEmail;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMailForPartyInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EditableEmail::updateOrCreate([
            'key' => 'invite_party_informations',
        ], [
            'title' => 'Mail informations pour la fête de clôture',
            'subject' => 'Fête Mission Nichtrauchen | 8 juin 2023',
            'text' => '',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY_INFORMATIONS',
        ], [
            'label' => 'Mail informations pour la fête de clôture',
            'description' => 'Classes ayant enregistré au moins un groupe pour la fête de clôture',
            'value' => Carbon::now()->addYears(10),
        ]);

        DB::table('editable_date_editable_email')
        ->updateOrInsert([
            'editable_email_key' => 'invite_party_informations',
        ], [
            'editable_date_key' => 'FINAL_INVITATION_PARTY_INFORMATIONS',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EditableEmail::where('key', 'invite_party_informations')->delete();
        EditableDate::where('key', 'FINAL_INVITATION_PARTY_INFORMATIONS')->delete();
    }
}

<?php

use App\EditableDate;
use App\EditableEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMailForPartyJ2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EditableEmail::updateOrCreate([
            'key' => 'invite_party_j_2',
        ], [
            'title' => 'Mail J-2 fête',
            'subject' => 'Mission Nichtrauchen | Fête finale - J-2',
            'text' => '',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY_J_2',
        ], [
            'label' => 'Invitation à la fête de clôture | J - 2',
            'description' => null,
            'value' => Carbon::now()->addYears(10),
        ]);

        DB::table('editable_date_editable_email')
        ->updateOrInsert([
            'editable_email_key' => 'invite_party_j_2',
        ], [
            'editable_date_key' => 'FINAL_INVITATION_PARTY_J_2',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EditableEmail::where('key', 'invite_party_j_2')->delete();
        EditableDate::where('key', 'FINAL_INVITATION_PARTY_J_2')->delete();
    }
}

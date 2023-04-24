<?php

use App\EditableEmail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CleanMissingEditableMailAndAddRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $editableEmailsDelete = [
            'party_group_reminder',
        ];
        EditableEmail::whereIn('key', $editableEmailsDelete)->delete();

        DB::table('editable_date_editable_email')
            ->updateOrInsert([
                'editable_email_key' => 'invite_party',
            ], [
                'editable_date_key' => 'FINAL_INVITATION_PARTY',
            ]);

        DB::table('editable_date_editable_email')
            ->updateOrInsert([
                'editable_email_key' => 'invite_party_reminder',
            ], [
                'editable_date_key' => 'FINAL_INVITATION_PARTY_REMINDER',
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

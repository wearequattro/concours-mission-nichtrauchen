<?php

use App\EditableDate;
use App\EditableEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMailForEducationalTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EditableEmail::updateOrCreate([
            'key' => 'new_educational_tool',
        ], [
            'title' => 'Mail nouvel outil pédagogique',
            'subject' => 'Nouvel outil pédagogique',
            'text' => '',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'NEW_EDUCATIONAL_TOOL',
        ], [
            'label' => 'Mail nouvel outil pédagogique',
            'description' => null,
            'value' => Carbon::now()->addYears(10),
        ]);

        DB::table('editable_date_editable_email')
        ->updateOrInsert([
            'editable_email_key' => 'new_educational_tool',
        ], [
            'editable_date_key' => 'NEW_EDUCATIONAL_TOOL',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EditableEmail::where('key', 'new_educational_tool')->delete();
        EditableDate::where('key', 'NEW_EDUCATIONAL_TOOL')->delete();
    }
}

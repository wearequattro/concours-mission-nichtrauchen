<?php

use App\EditableDate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToEditableDatesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY',
        ], [
            'description' => 'Classes ayant répondu à au moins 5 des 6 quiz',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_INVITATION_PARTY_REMINDER',
        ], [
            'description' => 'Classes ayant répondu à au moins 5 des 6 quiz',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_MAIL',
        ], [
            'description' => 'Classes ayant répondu à moins de 5 des 6 quiz',
        ]);

        EditableDate::updateOrCreate([
            'key' => 'FINAL_MAIL',
        ], [
            'description' => 'Classes ayant répondu à moins de 5 des 6 quiz',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editable_dates', function (Blueprint $table) {
            //
        });
    }
}

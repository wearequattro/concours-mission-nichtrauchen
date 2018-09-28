<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateLabels extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        \App\EditableDate::query()
            ->where('key', \App\EditableDate::NEWSLETTER_START)
            ->update([
                'label' => 'Début du concours Mission Nichtrauchen'
            ]);
        \App\EditableDate::query()
            ->where('key', \App\EditableDate::NEWSLETTER_ENCOURAGEMENT)
            ->update([
                'label' => 'Bravo – plus que 13 semaines... !'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}

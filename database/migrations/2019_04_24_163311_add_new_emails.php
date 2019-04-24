<?php

use App\EditableDate;
use App\EditableEmail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewEmails extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        EditableEmail::updateEmails();
        $toDelete = [
            'follow_up',
            'follow_up_yes',
            'follow_up_no',
            'party_confirmation',
        ];
        foreach ($toDelete as $key) {
            EditableEmail::query()->where('key', $key)->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}

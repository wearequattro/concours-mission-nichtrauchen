<?php

use App\EditableDate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewDates extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        foreach(EditableDate::getDefaultValues() as $entry) {
            /** @var EditableDate $found */
            $found = EditableDate::query()->where('key', $entry['key'])->first();
            if($found != null) {
                $found->update($entry);
            } else {
                EditableDate::create($entry);
            }
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

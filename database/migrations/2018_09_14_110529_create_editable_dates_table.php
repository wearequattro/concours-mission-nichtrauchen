<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditableDatesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('editable_dates', function (Blueprint $table) {
            $table->string('key');
            $table->string('label');
            $table->date('value');
            $table->timestamps();

            $table->primary('key');
        });

        foreach (\App\EditableDate::getDefaultValues() as $data) {
            \App\EditableDate::create($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('editable_dates');
    }
}

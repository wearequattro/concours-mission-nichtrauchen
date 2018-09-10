<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditableEmailsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('editable_emails', function (Blueprint $table) {
            $table->string('key');
            $table->string('title');
            $table->string('subject')->default('');
            $table->text('text');
            $table->timestamps();

            $table->primary('key');
        });

        \App\EditableEmail::addEmailsToDb();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('editable_emails');
    }
}

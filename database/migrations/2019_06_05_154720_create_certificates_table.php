<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_class_id');
            $table->string('url');
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_classes')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('certificates');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDocumentsAddSort extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedInteger('sort')->default(0)->after('visible_party');
        });
        foreach (\App\Document::all() as $doc) {
            $max = \App\Document::query()->max('sort');
            $doc->sort = $max + 1;
            $doc->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
}

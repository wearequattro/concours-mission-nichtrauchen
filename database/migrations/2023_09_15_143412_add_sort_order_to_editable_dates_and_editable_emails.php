<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortOrderToEditableDatesAndEditableEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editable_dates', function (Blueprint $table) {
            $table->integer('sort_order')->after('value')->default(0);
        });

        Schema::table('editable_emails', function (Blueprint $table) {
            $table->integer('sort_order')->after('text')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editable_dates', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('editable_emails', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
}

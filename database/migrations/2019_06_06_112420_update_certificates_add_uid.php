<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCertificatesAddUid extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('uid')->nullable(true)->after('url');
        });
        foreach(\App\Certificate::all() as $cert) {
            $cert->update(['uid' => \Ramsey\Uuid\Uuid::uuid4()->toString()]);
        }
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('uid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
}

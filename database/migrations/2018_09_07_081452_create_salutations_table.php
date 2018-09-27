<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalutationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('salutations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('long_form');
            $table->string('short_form');
            $table->timestamps();
        });

        $data = [
            [
                'long_form' => 'Monsieur',
                'short_form' => 'M.',
            ],
            [
                'long_form' => 'Madame',
                'short_form' => 'Mme',
            ],
        ];

        foreach ($data as $single) {
            \App\Salutation::create($single);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('salutations');
    }
}

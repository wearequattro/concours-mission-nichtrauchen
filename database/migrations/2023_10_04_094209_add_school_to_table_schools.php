<?php

use App\School;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolToTableSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        School::create([
            'name' => 'ECOLE INTERNATIONALE GASTON THORN',
            'address' => '17, rue Marguerite de Brabant',
            'postal_code' => 'L-1254',
            'city' => 'LUXEMBOURG-MERL',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

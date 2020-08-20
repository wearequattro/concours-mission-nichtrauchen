<?php


class TestDataSeeder extends \Illuminate\Database\Seeder {

    public function run() {
        factory(\App\User::class, 20)->create();
        factory(\App\SchoolClass::class, 40)->create();
    }

}

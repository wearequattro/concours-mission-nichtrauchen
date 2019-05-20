<?php

namespace App\Console\Commands;

use App\Setting;
use Illuminate\Console\Command;

class SettingMigrate extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Setting::addDefaults();
    }
}

<?php

namespace App\Console\Commands;

use App\Setting;
use Illuminate\Console\Command;

class SettingSet extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:set {setting} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a setting to a given value.';

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
        Setting::findOrFail($this->argument('setting'))->update(['value' => $this->argument('value') === 'true']);

        \Artisan::call('setting:get', ['setting' => $this->argument('setting')], $this->output);
    }
}

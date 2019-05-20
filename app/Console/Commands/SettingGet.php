<?php

namespace App\Console\Commands;

use App\Setting;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingGet extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:get {setting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a setting\'s value';

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
        $setting = $this->argument('setting');
        try {
            $value = Setting::findOrFail($setting)->value;
            $this->table([
                'Setting', 'Value'
            ], [
                [$setting, $value ? 'true' : 'false'],
            ]);
        } catch (ModelNotFoundException $e) {
            $this->error('Setting not found: "' . $setting . '"');
        }
    }
}

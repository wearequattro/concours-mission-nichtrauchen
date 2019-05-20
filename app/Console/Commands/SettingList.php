<?php

namespace App\Console\Commands;

use App\Setting;
use Illuminate\Console\Command;

class SettingList extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all setting\'s values';

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
        $settings = Setting::all()
            ->map(function (Setting $setting) {
                return [$setting->key, $setting->value ? 'true' : 'false'];
            })
            ->toArray();

        $this->table(['Setting', 'Value'], $settings);
    }
}

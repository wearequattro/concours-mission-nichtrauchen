<?php

namespace App\Console\Commands;

use App\Http\Controllers\FollowUpController;
use Illuminate\Console\Command;

class SendFollowUpEmails extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends follow up emails to applicable teachers';
    /**
     * @var FollowUpController
     */
    private $followUpController;

    /**
     * Create a new command instance.
     *
     * @param FollowUpController $followUpController
     */
    public function __construct(FollowUpController $followUpController) {
        parent::__construct();
        $this->followUpController = $followUpController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->followUpController->sendFollowUpForAll();
    }
}

<?php

namespace App\Console\Commands;

use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\PartyController;
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
     * Execute the console command.
     *
     * @param FollowUpController $followUpController
     * @param PartyController $partyController
     * @return mixed
     */
    public function handle(FollowUpController $followUpController, PartyController $partyController) {
        $followUpController->sendFollowUpForAll();
        $partyController->sendRemindersForAll();
    }
}

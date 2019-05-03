<?php

namespace App\Console\Commands;

use App\Http\Controllers\PartyController;
use App\SchoolClass;
use Illuminate\Console\Command;

class SendPartyInviteToClass extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:party-invite {class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends party invite to given class';

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
    public function handle(PartyController $partyController) {
        $arg = $this->argument('class');
        $class = SchoolClass::find($arg);
        $partyController->sendPartyInvite($class);
    }
}

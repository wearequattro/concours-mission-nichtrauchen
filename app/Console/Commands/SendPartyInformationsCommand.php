<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use Illuminate\Console\Command;

class SendPartyInformationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:party-informations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send party informations to eligible teams';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app(MailController::class)->sendPartyInformations();
    }
}

<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsletterController;
use App\User;
use Illuminate\Console\Command;

class SendNewsletter extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends newsletter to those users not having received it';
    /**
     * @var NewsletterController
     */
    private $newsletterController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NewsletterController $newsletterController) {
        parent::__construct();
        $this->newsletterController = $newsletterController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->newsletterController->sendNewsletters();
    }
}

<?php

namespace App\Console\Commands;

use App\EditableEmail;
use App\Http\Controllers\NewsletterController;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SendFinalMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:final';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends final mails';
    /**
     * @var SchoolClassRepository
     */
    private $classRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SchoolClassRepository $classRepository)
    {
        parent::__construct();
        $this->classRepository = $classRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendFinalMail($this->classRepository->findNotEligibleForCertificate(), EditableEmail::$MAIL_FINAL);
        $this->sendFinalMail($this->classRepository->findEligibleForCertificate(), EditableEmail::$MAIL_FINAL_CERTIFICAT);
    }

    private function sendFinalMail(Collection $classes, array $mailIdentifier) {
        $mail = EditableEmail::find($mailIdentifier);

        \Log::info('Sending ' . $mailIdentifier[0]);

        /** @var SchoolClass $class */
        foreach ($classes as $class) {
            if($mail->isSentToClass($class)) {
                \Log::info("Mail already sent to {$class->name} ({$class->id}), skipping...");
                continue;
            }
            \Log::info("Sending mail to {$class->name} ({$class->id})");
            \Mail::to($class->teacher->user->email)->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }
}

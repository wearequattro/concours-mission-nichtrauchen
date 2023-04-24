<?php

namespace App\Console\Commands;

use App\EditableEmail;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendFinalMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:final-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send final mail with key "final"';

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
        $mail = EditableEmail::find(EditableEmail::$MAIL_FINAL);
        $classes = $this->classRepository->findEligibleForFinalParty();

        Log::info('Sending ' . EditableEmail::$MAIL_FINAL[0]);

        /** @var SchoolClass $class */
        foreach ($classes as $class) {
            if($mail->isSentToClass($class)) {
                Log::info("Mail already sent to {$class->name} ({$class->id}), skipping...");
                continue;
            }
            Log::info("Sending mail to {$class->name} ({$class->id})");
            Mail::to($class->teacher->user->email)->queue(new CustomEmail($mail, $class->teacher, $class));
        }
    }
}

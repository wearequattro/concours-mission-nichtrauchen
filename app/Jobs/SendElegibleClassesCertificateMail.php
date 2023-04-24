<?php


namespace App\Jobs;

use App\EditableEmail;
use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;
use App\Mail\CustomEmail;
use App\Mail\TeacherCertificateMail;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendElegibleClassesCertificateMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param SchoolClassRepository $repository
     * @param SchoolClassManager    $manager
     *
     * @return void
     */
    public function handle(SchoolClassRepository $repository, SchoolClassManager $manager)
    {
        $classes = $repository->findHavingCertificateToBeSent();

        $classes->each(function (SchoolClass $class) use ($manager) {
            \Mail::to($class->teacher->user->email)->queue(new TeacherCertificateMail($class->teacher, $class));
            $class->certificate->update([
                'sent_at' => Carbon::now()
            ]);
        });

    }
}

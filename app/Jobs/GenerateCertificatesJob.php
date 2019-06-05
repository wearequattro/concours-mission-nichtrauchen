<?php

namespace App\Jobs;

use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;
use App\SchoolClass;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCertificatesJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     *
     * @param SchoolClassRepository $repository
     * @param SchoolClassManager $manager
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Exception
     */
    public function handle(SchoolClassRepository $repository, SchoolClassManager $manager) {
        $classes = $repository->findEligibleForCertificate();
        \Log::info('GenerateCertificatesJob started: generating ' . $classes->count() . ' certificates');

        $classes->each(function (SchoolClass $class) use ($manager) {
            $manager->generateCertificate($class);
        });

        \Log::info('GenerateCertificatesJob completed: ' . $classes->count());
    }
}

<?php

namespace App\Console;

use App\Console\Commands\SendFollowUpEmails;
use App\Console\Commands\SendNewsletter;
use App\Console\Commands\QuizUpdateCommand;
use App\Console\Commands\SendFinalMailCommand;
use App\Console\Commands\SendFinalMailsCommand;
use App\Console\Commands\SendPartyInformationsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Backup\Commands\CleanupCommand;
use Spatie\Backup\Commands\MonitorCommand;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command(SendFollowUpEmails::class)->dailyAt('10:03')->withoutOverlapping();
        // $schedule->command(SendNewsletter::class)->everyTenMinutes()->withoutOverlapping();
        // if(\App::environment() == 'production') {
        //     // Stop backups as we use Hetzner's backup system
        //     // $schedule->command(BackupCommand::class)->dailyAt('3:30');
        //     // $schedule->command(MonitorCommand::class)->dailyAt('9:00');
        //     // $schedule->command(CleanupCommand::class)->dailyAt('14:00');
        // }
        $schedule->command(SendFinalMailsCommand::class)->dailyAt('10:03')->withoutOverlapping();
        $schedule->command(SendPartyInformationsCommand::class)->dailyAt('10:03')->withoutOverlapping();
        $schedule->command(QuizUpdateCommand::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

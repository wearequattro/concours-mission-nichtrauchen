<?php

namespace App\Console\Commands;

use App\Quiz;
use Illuminate\Console\Command;

class QuizUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates quiz states if their closing time has been reached.';

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
        Quiz::query()
            ->where('closes_at', '<=', \DB::raw('CURRENT_TIMESTAMP'))
            ->where('state', '=', Quiz::STATE_RUNNING)
            ->update([
                'state' => Quiz::STATE_CLOSED
            ]);

        return 0;
    }
}

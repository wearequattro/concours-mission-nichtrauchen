<?php


namespace App\Listeners;


use App;
use Carbon\Carbon;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DatabaseLogger
{

    public function subscribe(Dispatcher $events)
    {
        $events->listen(QueryExecuted::class, DatabaseLogger::class);
    }

    public function handle(QueryExecuted $event)
    {
        if (config('app.debug') == false) {
            return;
        }
        Log::info(sprintf("DB QUERY: %s (Time: %sms)",
            Str::replaceArray('?', $this->formatBindings($event->bindings), $event->sql),
            $event->time
        ));
    }

    private function formatBindings(array $bindings)
    {
        return array_map(function ($obj) {
            if ($obj instanceof \DateTime) {
                /** @var \DateTime obj */
                return $obj->format(Carbon::DEFAULT_TO_STRING_FORMAT);
            }
            return $obj;
        }, $bindings);
    }

}
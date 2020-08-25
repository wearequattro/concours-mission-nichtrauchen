<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('matchAll', function (callable $predicate) {
            return $this->filter($predicate)->count() == $this->count();
        });
        Collection::macro('matchAny', function (callable $predicate) {
            return $this->filter($predicate)->count() > 0;
        });
    }
}

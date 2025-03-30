<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }


    public static function listen(): array
    {
        return [

        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (self::listen() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, [$listener, 'handle']);
            }
        }
    }

}

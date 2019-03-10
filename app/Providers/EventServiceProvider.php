<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],

        'App\Events\Documents\DocumentUpdatedOrCreatedEvent' => [
            'Prettus\Repository\Listeners\CleanCacheRepository',
            'App\Listeners\Documents\DocumentUpdatedOrCreatedListener'
        ],

        'App\Events\Documents\DocumentDeletedEvent' => [
            'Prettus\Repository\Listeners\CleanCacheRepository',
            'App\Listeners\Documents\DocumentDeletedListener'
        ],
    ];
}

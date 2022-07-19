<?php

namespace App\Providers;

use App\Listeners\BroadcastUserEnterNotification;
use App\Listeners\BroadcastUserExitNotification;
use App\Events\Enter;
use App\Events\Exited;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Enter::class => [
            BroadcastUserEnterNotification::class
        ],
        Exited::class => [
            BroadcastUserExitNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

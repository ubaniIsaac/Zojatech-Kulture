<?php

namespace App\Providers;

use App\Events\ProducerEvent;
use App\Events\SignUpEvent;
use App\Events\UserPurchaseEvent;
use App\Listeners\Producerlistener;
use App\Listeners\SignUplistener;
use App\Listeners\UserPurchaselistener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SignUpEvent::class => [
            SignUplistener::class
        ],
        UserPurchaseEvent::class => [
            UserPurchaselistener::class
        ],
        ProducerEvent::class => [
            Producerlistener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

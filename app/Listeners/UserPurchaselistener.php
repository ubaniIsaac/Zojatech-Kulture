<?php

namespace App\Listeners;

use App\Events\UserPurchaseEvent;
use App\Mail\UserPurchaseMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserPurchaselistener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserPurchaseEvent $event): void
    {
        //
        Mail::to($event->artiste->email)->send(new UserPurchaseMail($event->artiste, $event->beat));
    }
}

<?php

namespace App\Listeners;

use App\Events\ProducerEvent;
use App\Mail\ProducerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class Producerlistener
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
    public function handle(ProducerEvent $event): void
    {
        Mail::to($event->producer->email)->send(new ProducerMail($event->producer, $event->beat));

    }
}

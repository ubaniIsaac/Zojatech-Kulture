<?php

namespace App\Listeners;

use App\Models\User;
use App\Mail\SigninMail;
use App\Events\SigninEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SigninListener
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
    public function handle(SigninEvent $event): void
    {
        //
        Mail::to($event->user->email)->send(new SigninMail($event->user));
        

    }
}

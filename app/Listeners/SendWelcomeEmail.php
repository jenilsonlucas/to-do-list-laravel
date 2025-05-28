<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Verified;
use IlluminateAuthEventsVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
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
    public function handle(Verified $event): void
    {
        $user = $event->user;

        Mail::to($user->email)
        ->queue(new WelcomeEmail($user));
    }
}

<?php

namespace Tests\Unit;

use App\Listeners\SendWelcomeEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendWelcomeEmailTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function listener_send_welcome_email()
    {
        Mail::fake();

        $user = User::factory()->create();

        $event = new Verified($user);
        $listener = new SendWelcomeEmail();
        $listener->handle($event);

        Mail::assertQueued(WelcomeEmail::class, function(WelcomeEmail $email) use ($user){
            return $email->hasTo($user->email);
        });
    }    
}

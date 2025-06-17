<?php

namespace Tests\Unit;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WelcomeEmailTest extends TestCase
{
    use RefreshDatabase;
    
    #[Test]
    public function welcome_email_content_view_and_user()
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com'
        ]);

        $mailable = new WelcomeEmail($user);

        $this->assertEquals('emails.welcome', $mailable->content()->view);

        $html = $mailable->render();

        $mailable->assertSeeInHtml($user->name);
    }
}

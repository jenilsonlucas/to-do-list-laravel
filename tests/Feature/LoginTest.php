<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function login_page_is_accessible():void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('auth');
    }

    #[Test]
    public function user_can_login_with_valid_crendentials():void
    {
        $user = User::factory()->create([
            "password" => bcrypt('12345678')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertRedirect("/app");
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function user_can_login_with_remember():void
    {
        $user = User::factory()->create([
            "password" => bcrypt('12345678')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678',
            'remember' => 1
        ]);

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function session_is_regenerate_after_sucessful_login():void
    {
        $user = User::factory()->create([
            "password" => bcrypt('12345678')
        ]);

        $this->startSession();

        $oldSession = session()->getId();

        $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $newSession = session()->getId();

        $this->assertNotEquals($oldSession, $newSession);
    }


    #[Test]
    public function user_cannot_login_with_invalid_crendentials():void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
        $response->assertSessionHas('credentials');
        $response->assertRedirectBack();
    }


    #[Test]
    public function login_requires_valid_email_and_password():void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => 'invalid - email',
            'password' => ''
        ]);

        $response->assertRedirectBack();
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    #[Test]
    public function user_can_logout():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sair');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    #[Test]
    public function session_invalid_and_regenerated_after_logout():void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->startSession();

        $oldSession = session()->token();

        $this->get('/sair');

        $newSession = session()->token();

        $this->assertNotEquals($oldSession, $newSession);
        $this->assertGuest();
    }
}

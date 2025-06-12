<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Registered;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_registered_with_valid_information():void
    {

        Event::fake();

        $response = $this->post('/register', [
            'name' => 'Jenilson Lucas',
            'email' => 'jenilsonllucas@gmail.com',
            'image' => '/image/jenilson.jpg',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);


        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'jenilsonllucas@gmail.com']);
        Event::assertDispatched(Registered::class);
        $response->assertRedirectToRoute('verification.notice', ['email' => 'jenilsonllucas@gmail.com']);    
    }

    #[Test]
    public function registration_required_all_fields():void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function user_cannot_register_with_invalidated_data():void{

        $response = $this->post('/register', [
            'name' => 123456534,
            'email' => 'jenilson',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

}

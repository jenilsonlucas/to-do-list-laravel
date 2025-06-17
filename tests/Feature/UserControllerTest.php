<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use function PHPSTORM_META\map;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function view_of_the_profile_is_accessible(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/perfil');

        $response->assertOk();

        $response->assertViewHas(['user', 'categories']);
    }

    #[Test]
    public function user_can_update_your_informations(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->put("/perfil/{$user->id}", [
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'photo' => $file
        ]);


        $user->refresh();
        $name = str_replace("storage/", "", $user->image);
        Storage::disk('public')->assertExists($name);

        $response->assertRedirectToRoute('user.edit');

        $response->assertSessionHas('message_flash');
    }
}

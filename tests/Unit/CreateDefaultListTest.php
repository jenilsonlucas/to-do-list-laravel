<?php

namespace Tests\Unit;

use App\Listeners\CreateDefaultList;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateDefaultListTest extends TestCase
{
    use RefreshDatabase;
    
    #[Test]
    public function listener_create_default_list(): void
    {   
        $user = User::factory()->create();

        $this->assertCount(0, $user->categories);

        $event = new Verified($user);
        $listener = new CreateDefaultList();
        $listener->handle($event);

        $user->refresh();
        $this->assertCount(1, $user->categories);
        $this->assertEquals('Minhas tarefas', $user->categories->first()->name);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function testing_relationship_from_user():void
    {
        $user = User::factory()->create();

        $categories = Category::factory(2)->create([
            'user_id' => $user->id
        ]); 

        $tasks = Task::factory(2)->create([
            'user_id' => $user->id,
            'category_id' => $categories->first()->id
        ]);

        $this->assertModelExists($user);
        $this->assertCount(2, $user->tasks);
        $this->assertCount(2, $user->categories);

    }
}

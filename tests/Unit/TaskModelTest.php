<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testing_relationship_from_Tasks():void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);

        $this->assertModelExists($task->user);
        $this->assertModelExists($task->category);

    }
}

<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testing_relationship_from_categories():void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $tasks = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'completed' => 1
        ]);

        $tasks = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'completed' => 0
        ]);
        

        $this->assertModelExists($category->user);
        $this->assertCount(1, $category->tasksDone);
        $this->assertCount(1, $category->tasksUndone);
        $this->assertCount(2, $category->tasks);

    }
}

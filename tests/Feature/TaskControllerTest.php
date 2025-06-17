<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function user_can_stored_task_with_valid_information(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/tarefas', [
            'name' => 'nova tarefa',
            'description' => 'fazer alguma coisa',
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'task' => ['id', 'name', 'description', 'user_id', 'category_id', 'created_at', 'updated_at']
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => 'nova tarefa',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'completed' => 0
        ]);
    }

    #[Test]
    public function name_and_category_id_is_required(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson('/tarefas', [
            'name',
            'category_id',
            'description' => 'alguma coisa'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name',
            'category_id'
        ]);
    }

    #[Test]
    public function user_can_updated_a_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);

        $response = $this->putJson("/tarefas/{$task->id}", [
            'name' => 'novo nome'
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['message']);
    
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'novo nome'
        ]);
    }

    #[Test]
    public function user_cannot_updated_a_task_not_existing():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson('/tarefas/5',[
            'name' => 'novo nome',
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_task():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);
        $task = Task::factory()->create([
            'name' => 'teste',
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);

        $response = $this->deleteJson("/tarefas/{$task->id}");

        $response->assertOk();

        $response->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('tasks', [
            'name' => 'teste',
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
    }

    #[Test]
    public function user_cannot_delete_a_task_not_existing():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->deleteJson('/tarefas/3');

        $response->assertStatus(404);
    }
}

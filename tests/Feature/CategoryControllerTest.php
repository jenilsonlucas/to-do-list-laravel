<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function category_view_is_acessible(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/app');

        $response->assertOk();
        $response->assertViewIs('category.list');

        $response->assertViewHas([
            'categories'
        ]);
    }

    #[Test]
    public function response_for_a_the_search(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/app?s=5&option=category');

        $response->assertOk();
        $response->assertViewIs('category.list');

        $response->assertViewHas([
            'categories'
        ]);
    }

    #[Test]
    public function user_can_stored_category_with_valid_information(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/app', [
            'name' => 'trabalhos'
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'category' => ['name', 'user_id', 'created_at', 'updated_at', 'id'],
            'message'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'trabalhos'
        ]);
    }

    #[Test]
    public function is_requered_name_field_request_in_json(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/app', [
            'name' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function user_can_updated_a_category_existing(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->putJson("/categoria/{$category->id}", [
            'name' => "Novo nome"
        ]);

        $response->assertOk();
        $response->assertJson([
            'redirect' => url('/app')
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Novo nome',
            'user_id' => $user->id
        ]);
    }

    #[Test]
    public function user_cannot_updated_a_category_not_existing(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->putJson("/categoria/12", [
            'name' => 'Novo nome'
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_category_existing(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson("/categoria/{$category->id}");

        $response->assertOk();

        $response->assertJson([
            'message' => 'Categoria ' . $category->name . ' apagada com sucesso!'
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }

    #[Test]
    public function user_cannot_delete_a_category_not_existing(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->deleteJson('/categoria/12');


        $response->assertStatus(404);
    }

    #[Test]
    public function all_tasks_it_is_deleted_when_the_category_related_is_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'completed' => 1
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->deleteJson("/categoria/{$category->id}");

        $response->assertOk();

        $response->assertJson([
            'message' => 'Categoria ' . $category->name . ' apagada com sucesso!'
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $otherTask->id
        ]);
    }

    #[Test]
    public function user_can_delete_all_tasks_done(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create([
            'user_id' => $user->id
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'completed' => 1
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'completed' => 1
        ]);

        $response = $this->deleteJson("/categoria/{$category->id}/tasks/done");

        $response->assertOk();

        $response->assertJson([
            'redirect' => url('/app')
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $otherTask->id
        ]);
    }

    
}

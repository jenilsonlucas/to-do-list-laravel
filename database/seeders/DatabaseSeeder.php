<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Database\Factories\CategoryFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create([
        //     'password' => 12345678
        // ]        
        // );

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

       /* User::factory(5)
        ->hasCategories(5)
        ->create();*/

        // User::factory(2)
        // ->has(
        //     Category::factory(2)
        //     ->has(
        //         Task::factory(1)->for(User::factory())
        //     )
        //     )->create();

        //  Category::factory(5)->create();
        Task::factory(5)->create();
     }
}

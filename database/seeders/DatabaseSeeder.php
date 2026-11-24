<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = Category::factory(5)->create();
        $authors = Author::factory(6)->create();

        $pick = fn () => [
            'category_id' => $categories->random()->id,
            'author_id' => $authors->random()->id,
        ];

        Article::factory(20)->state($pick)->create();
    }
}

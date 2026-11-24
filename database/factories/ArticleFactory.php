<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->headline();

        return [
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'title' => $title,
            'summary' => fake()->realText(200),
            'body' => collect(range(1, fake()->numberBetween(4, 8)))
                ->map(fn () => fake()->realText(fake()->numberBetween(300, 700)))
                ->implode("\n\n"),
            'permalink' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    private function headline(): string
    {
        $text = preg_replace("/(?<![A-Za-z])'|'(?![A-Za-z])|[\"()]|--/", ' ', fake()->realText(120));

        $fragment = collect(preg_split('/[.!?;:]+/', $text))
            ->map(fn (string $part) => Str::squish(trim($part, " ,-")))
            ->first(fn (string $part) => str_word_count($part) >= 4) ?? Str::squish($text);

        return ucwords(Str::lower(Str::words($fragment, 10, '')));
    }
}

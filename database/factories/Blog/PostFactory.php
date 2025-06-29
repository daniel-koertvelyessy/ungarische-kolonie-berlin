<?php

declare(strict_types=1);

namespace Database\Factories\Blog;

use App\Enums\EventStatus;
use App\Models\Blog\Post;
use App\Models\Blog\PostType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ['de' => fake()->text(50), 'hu' => fake()->text(50)],
            'slug' => ['de' => fake()->text(), 'hu' => fake()->text()],
            'body' => ['de' => fake()->text(), 'hu' => fake()->text()],
            'user_id' => User::factory()->create()->id,
            'status' => fake()->randomElement(EventStatus::toArray()),
            'post_type_id' => PostType::factory()->create()->id,
            'label' => fake()->text(30),
            'published_at' => Carbon::today()->format('Y-m-d'),

        ];
    }
}

<?php

namespace Database\Factories;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{

    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $when = $this->faker->boolean(50)
            ? $this->faker->dateTimeBetween('-2 months', 'now')
            : $this->faker->dateTimeBetween('now', '+2 months');

        return [
            'title'        => $this->faker->sentence(),
            'description'  => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            // pick a random existing user id OR create one and use its id
            'author_id'    => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'publish_at'   => $when,
            'time_to_read' => $this->faker->numberBetween(3, 15),
            'status'       => $this->faker->randomElement(['draft', 'private', 'published']),
        ];
    }
}

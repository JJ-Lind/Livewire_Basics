<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): PostFactory
    {
        return $this->afterCreating(function (Post $post) {
            Comment::factory()->count(mt_rand(1,5))->for($post)->create();
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'content' => $this->faker->paragraph,
        ];
    }
}

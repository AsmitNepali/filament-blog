<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Magan\FilamentBlog\Models\CategoryPost;

class CategoryPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryPost::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'post_id' => $this->faker->randomNumber(),
            'category_id' => $this->faker->randomNumber(),
        ];
    }
}

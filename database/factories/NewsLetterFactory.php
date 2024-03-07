<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Magan\FilamentBlog\Models\NewsLetter;

class NewsLetterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsLetter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
        ];
    }
}

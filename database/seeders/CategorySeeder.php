<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Magan\FilamentBlog\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(10)->create();
    }
}

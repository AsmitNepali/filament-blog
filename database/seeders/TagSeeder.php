<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Magan\FilamentBlog\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(50)->create();
    }
}

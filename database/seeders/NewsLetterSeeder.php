<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Magan\FilamentBlog\Models\NewsLetter;

class NewsLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsLetter::factory(100)->create();
    }
}

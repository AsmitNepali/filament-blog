<?php

namespace Database\Seeders;

use App\Models\NewsLetter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

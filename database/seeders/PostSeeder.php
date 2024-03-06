<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SeoDetail;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->hasAttached(
                Category::factory()->count(3))
            ->hasAttached(Tag::factory()->count(3))
            ->has(SeoDetail::factory()->count(1))
            ->has(Comment::factory()->count(5))
            ->create();
    }
}

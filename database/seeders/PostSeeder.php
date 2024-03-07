<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Magan\FilamentBlog\Models\Category;
use Magan\FilamentBlog\Models\Comment;
use Magan\FilamentBlog\Models\Post;
use Magan\FilamentBlog\Models\SeoDetail;
use Magan\FilamentBlog\Models\Tag;

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

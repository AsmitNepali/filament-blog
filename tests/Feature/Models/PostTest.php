<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\SeoDetail;
use App\Models\Tag;

it('has categories', function () {
    // Arrange
    $post = Post::factory()
        ->hasAttached(Category::factory()->count(3))
        ->create();

    // Act & Assert
    expect($post->categories)
        ->toHaveCount(3)
        ->each
        ->toBeInstanceOf(Category::class);
});

it('has tags', function () {
    // Arrange
    $post = Post::factory()
        ->hasAttached(Tag::factory()->count(3))
        ->create();

    // Act & Assert
    expect($post->tags)
        ->toHaveCount(3)
        ->each
        ->toBeInstanceOf(Tag::class);
});

it('has seoDeatil', function () {
    // Arrange
    $post = Post::factory()->has(SeoDetail::factory(1))
        ->create();

    // Act & Assert
    expect($post->seoDetail)
        ->toBeInstanceOf(SeoDetail::class);

});

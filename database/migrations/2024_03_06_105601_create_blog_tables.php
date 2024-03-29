<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('sub_title')->nullable();
            $table->longText('body');
            $table->enum('status', ['published', 'scheduled', 'pending'])->default('pending');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('scheduled_for')->nullable();
            $table->string('cover_photo_path');
            $table->string('photo_alt_text');
            $table->foreignId(config('filamentblog.user_model'));
            $table->timestamps();
        });

        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Magan\FilamentBlog\Models\Post::class);
            $table->foreignIdFor(Magan\FilamentBlog\Models\Category::class);
            $table->timestamps();
        });

        Schema::create('seo_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Magan\FilamentBlog\Models\Post::class);
            $table->string('title');
            $table->json('keywords')->nullable();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('filamentblog.user_model'));
            $table->foreignIdFor(Magan\FilamentBlog\Models\Post::class);
            $table->text('comment');
            $table->boolean('approved');
            $table->timestamps();
        });

        Schema::create('news_letters', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->unique();
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Magan\FilamentBlog\Models\Post::class);
            $table->foreignIdFor(Magan\FilamentBlog\Models\Tag::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('seo_details');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('news_letters');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('post_tag');
    }
};

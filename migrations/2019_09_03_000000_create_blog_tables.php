<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = config('nova-blog.tables');

        Schema::create($tables['categories'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create($tables['posts'], function (Blueprint $table) use ($tables) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->jsonb('keywords')->nullable()->default('[]');
            $table->string('description')->nullable();
            $table->string('template');
            $table->text('annotation')->nullable();
            $table->text('content')->nullable();
            $table->integer('category_id')->unsigned();
            $table->bigInteger('author_id')->unsigned();
            $table->timestamps();
            $table->timestamp('published_at')->useCurrent();

            $table->foreign('category_id')->references('id')->on($tables['categories'])->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on($tables['users'])->onDelete('cascade');
            $table->index('published_at');
        });

        if (config('database.default') === 'pgsql') {
            DB::statement(sprintf('alter table %s add ts tsvector null', $tables['posts']));
            DB::statement(sprintf('create index %1$s_ts_index on %1$s using gin (ts)', $tables['posts']));
        }

        Schema::create($tables['tags'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create($tables['post_tags'], function (Blueprint $table) use ($tables) {
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('post_id')->references('id')->on($tables['posts'])->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on($tables['tags'])->onDelete('cascade');

        });

        Schema::create($tables['comments'], function (Blueprint $table) use ($tables) {
            $table->increments('id');
            $table->string('content', 4000);
            $table->integer('post_id')->unsigned();
            $table->bigInteger('author_id')->unsigned();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on($tables['posts'])->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on($tables['users'])->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = config('nova-blog.tables');
        Schema::dropIfExists($tables['comments']);
        Schema::dropIfExists($tables['post_tags']);
        Schema::dropIfExists($tables['tags']);
        Schema::dropIfExists($tables['posts']);
        Schema::dropIfExists($tables['categories']);
    }
}

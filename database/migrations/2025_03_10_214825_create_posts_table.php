<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('title');
            $table->json('slug')->unique();
            $table->json('body');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', \App\Enums\EventStatus::toArray())->default(\App\Enums\EventStatus::DRAFT->value);
            $table->foreignId('post_type_id')->constrained('post_types');
            $table->string('label', 255)->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('caption')->nullable();
            $table->string('author')->nullable();
            $table->string('filename');
            $table->string('original_filename');
            $table->foreignId('post_id')->constrained();
        });
    }
};

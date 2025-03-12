<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table)
        {
            if (!Schema::hasColumn('posts', 'post_type_id')) {
                $table->foreignId('post_type_id')
                    ->constrained('post_types');
            }
            if (!Schema::hasColumn('posts', 'label')) {
                $table->string('label', 255)
                    ->nullable();
            }
            if (!Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')
                    ->nullable();
            }
        });

        if (!Schema::hasTable('post_images')) {
            Schema::create('post_images', function (Blueprint $table)
            {
                $table->id();
                $table->timestamps();
                $table->json('caption')
                    ->nullable();
                $table->string('filename');
                $table->string('original_filename');
                $table->foreignId('post_id')
                    ->constrained();
                $table->string('author')
                    ->nullable();
            });
        } else {
            Schema::table('post_images', function (Blueprint $table)
            {
                $table->string('author')
                    ->nullable();
            });
        }
    }

};

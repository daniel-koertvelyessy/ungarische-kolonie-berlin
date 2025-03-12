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
            $table->foreignId('post_type_id')
                ->constrained('post_types');
            $table->string('label', 255)
                ->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::table('post_images', function (Blueprint $table)
        {
            $table->string('author')
                ->nullable();
        });
    }

};
